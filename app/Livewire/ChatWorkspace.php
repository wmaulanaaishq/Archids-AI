<?php

namespace App\Livewire;

use App\Models\ChatLog;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Services\ArchiAIService;
use App\Models\ProjectDocument;
use App\Services\ChromaDBService;
use App\Services\PdfRagService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Smalot\PdfParser\Parser;

#[Layout('components.layouts.app')]
#[Title('ArchiAgent — AI Invoice Assistant')]
class ChatWorkspace extends Component
{
    use WithFileUploads;

    public $pdfFile;
    
    /**
     * Input pesan dari user.
     */
    public string $message = '';

    /**
     * Pencarian proyek di sidebar.
     */
    public string $searchProject = '';

    /**
     * ID Proyek yang sedang dipilih.
     */
    public ?int $selectedProjectId = null;

    /**
     * Riwayat chat sesi saat ini.
     * Format: [['role' => 'user'|'assistant', 'content' => '...', 'download_url' => '...(opsional)'], ...]
     */
    public array $chatLogs = [];

    /**
     * Menampilkan kartu konfirmasi draft invoice.
     */
    public bool $showConfirmationCard = false;

    /**
     * Data draft invoice dari AI (hasil function calling).
     */
    public array $draftData = [];

    /**
     * Flag edit inline untuk draft invoice.
     */
    public bool $isEditingDraft = false;

    /**
     * Flag loading state.
     */
    public bool $isProcessing = false;

    /**
     * State untuk edit nama proyek.
     */
    public ?int $editingProjectId = null;
    public string $editingProjectName = '';

    /**
     * Mount: load history
     */
    public function mount(): void
    {
        $this->loadChatHistory();
    }

    /**
     * Load riwayat chat dari database
     */
    public function loadChatHistory(): void
    {
        $userId = Auth::id() ?? 1;
        
        $logs = ChatLog::where('user_id', $userId)
            ->where('project_id', $this->selectedProjectId)
            ->orderBy('created_at', 'asc')
            ->get();
            
        if ($logs->isEmpty()) {
            $this->chatLogs = [];
        } else {
            $this->chatLogs = $logs->map(fn($log) => [
                'role' => $log->role,
                'content' => $log->content,
                'download_url' => $log->download_url,
            ])->toArray();
        }
        
        $this->dispatch('scroll-to-bottom');
    }

    /**
     * Simpan pesan ke memori array dan database
     */
    private function appendChatAndSave(string $role, string $content, ?string $downloadUrl = null): void
    {
        $this->chatLogs[] = [
            'role' => $role,
            'content' => $content,
            'download_url' => $downloadUrl,
        ];
        
        $userId = Auth::id() ?? 1;
        ChatLog::create([
            'user_id' => $userId,
            'project_id' => $this->selectedProjectId,
            'role' => $role,
            'content' => $content,
            'download_url' => $downloadUrl,
        ]);
    }

    /**
     * Kirim pesan user ke AI dan proses respons.
     */
    public function sendMessage(): void
    {
        $trimmed = trim($this->message);
        if ($trimmed === '') {
            return;
        }

        // 1. Masukkan pesan user ke chatLogs dan database
        $this->appendChatAndSave('user', $trimmed);

        // Simpan pesan lalu kosongkan input
        $userMessage = $trimmed;
        $this->message = '';
        $this->isProcessing = true;

        try {
            // 2. Siapkan history untuk AI (sliding window)
            $maxHistory = (int) config('archiai.max_history_messages', 20);
            $historyForAI = collect($this->chatLogs)
                ->filter(fn($log) => in_array($log['role'], ['user', 'assistant']))
                ->map(fn($log) => [
                    'role' => $log['role'],
                    'content' => $log['content'],
                ])
                ->slice(-$maxHistory)
                ->values()
                ->toArray();

            // Hapus pesan terakhir (karena processChat akan menambahkannya sendiri)
            array_pop($historyForAI);

            // 3. Bangun Konteks Klien/Proyek jika ada yang sedang dipilih
            $systemContext = null;
            if ($this->selectedProjectId) {
                $activeProject = Project::with(['client', 'invoices'])->find($this->selectedProjectId);
                if ($activeProject) {
                    $systemContext = "INFORMASI KONTEKS SAAT INI:\n";
                    $systemContext .= "User sedang bekerja pada ruang kerja proyek spesifik. Jika user meminta membuat draft tanpa menyebut nama klien/proyek, SELALU GUNAKAN data berikut:\n";
                    $systemContext .= "- Nama Klien: " . ($activeProject->client->client_name ?? '-') . "\n";
                    $systemContext .= "- Nama Proyek: " . $activeProject->project_name . "\n\n";
                    
                    if ($activeProject->invoices->isNotEmpty()) {
                        $systemContext .= "Riwayat Termin yang SUDAH DIBUAT (jangan buat ulang termin ini):\n";
                        foreach ($activeProject->invoices as $inv) {
                            $systemContext .= "  - {$inv->invoice_number} | {$inv->termin_name} ({$inv->percentage}%)\n";
                        }
                    } else {
                        $systemContext .= "Belum ada termin yang dibuat untuk proyek ini (ini akan menjadi termin pertama).\n";
                    }
                }
            }

            // --- RAG: Cek ChromaDB untuk referensi PDF ---
            $ragService = app(PdfRagService::class);
            $ragContext = $ragService->searchRelevantContext($userMessage, $this->selectedProjectId);
            
            if (!empty($ragContext)) {
                $systemContext = ($systemContext ?? '') . $ragContext;
            }

            // 4. Panggil ArchiAIService
            $service = app(ArchiAIService::class);
            $result = $service->processChat($userMessage, $historyForAI, $systemContext);

            // 4. Handle response
            if ($result['type'] === 'function_call') {
                // AI mengembalikan draft invoice → tampilkan kartu konfirmasi
                $this->draftData = $result['data']['arguments'] ?? [];
                $this->showConfirmationCard = true;

                $this->chatLogs[] = [
                    'role' => 'assistant',
                    'content' => "Saya telah mengekstrak data invoice dari percakapan kita. Silakan periksa **Kartu Konfirmasi** di bawah dan pastikan semua data sudah benar sebelum diproses. ✅",
                ];
            } else {
                // AI mengembalikan pesan teks biasa
                $aiResponse = $result['data']['content'] ?? 'Maaf, saya tidak dapat memproses permintaan Anda.';
                $this->appendChatAndSave('assistant', $aiResponse);
            }
        } catch (\Exception $e) {
            Log::error('ChatWorkspace sendMessage Error', [
                'message' => $e->getMessage(),
            ]);

            $this->appendChatAndSave('assistant', '⚠️ Maaf, terjadi kesalahan saat menghubungi server AI. Silakan coba lagi dalam beberapa saat.');
        } finally {
            $this->isProcessing = false;
            $this->dispatch('scroll-to-bottom');
        }
    }

    /**
     * Konfirmasi dan simpan draft invoice ke database.
     */
    public function confirmAndSave(): void
    {
        if (empty($this->draftData)) {
            return;
        }

        try {
            // 1. Dapatkan atau buat user_id (gunakan user_id = 1 sebagai default jika belum ada auth)
            $userId = Auth::id() ?? 1;

            // 2. Cari atau buat klien berdasarkan nama
            $client = Client::firstOrCreate(
                [
                    'user_id' => $userId,
                    'client_name' => $this->draftData['client_name'] ?? 'Unknown Client',
                ],
                [
                    'phone_number' => '-',
                    'project_address' => '-',
                ]
            );

            // 3. Cari atau buat proyek berdasarkan nama klien + proyek
            $project = Project::firstOrCreate(
                [
                    'client_id' => $client->id,
                    'project_name' => $this->draftData['project_name'] ?? 'Unknown Project',
                ],
                [
                    'total_contract_value' => 0,
                    'status' => 'Briefing',
                ]
            );

            // 4. Insert invoice baru dengan status Pending
            $invoice = Invoice::create([
                'project_id' => $project->id,
                'invoice_number' => $this->draftData['invoice_number'] ?? 'INV-' . time(),
                'termin_name' => $this->draftData['termin_name'] ?? '-',
                'percentage' => (int) ($this->draftData['percentage'] ?? 0),
                'amount' => (int) ($this->draftData['amount'] ?? 0),
                'status' => 'Pending',
            ]);

            // 5. Jika ini dari "New Chat", tautkan semua riwayat obrolan ke proyek baru ini
            if (is_null($this->selectedProjectId)) {
                ChatLog::where('user_id', $userId)
                    ->whereNull('project_id')
                    ->update(['project_id' => $project->id]);
                
                $this->selectedProjectId = $project->id;
            }

            // 6. Reset state konfirmasi
            $this->showConfirmationCard = false;
            $this->draftData = [];

            // 6. Tambahkan pesan sukses dengan link download ke database
            $downloadUrl = route('invoice.download', $invoice->id);
            $formattedAmount = 'Rp ' . number_format($invoice->amount, 0, ',', '.');
            
            $successMsg = "✅ **Invoice berhasil disimpan!**\n\n"
                . "📄 **{$invoice->invoice_number}** — {$invoice->termin_name}\n"
                . "💰 Nominal: **{$formattedAmount}**\n"
                . "📊 Status: **Pending**\n\n"
                . "Silakan unduh invoice Anda melalui tombol di bawah ini.";

            $this->appendChatAndSave('assistant', $successMsg, $downloadUrl);

        } catch (\Exception $e) {
            Log::error('ChatWorkspace confirmAndSave Error', [
                'message' => $e->getMessage(),
                'draft_data' => $this->draftData,
            ]);

            $this->appendChatAndSave('assistant', '⚠️ Maaf, terjadi kesalahan saat menyimpan invoice. Silakan coba lagi.');
        }

        $this->dispatch('scroll-to-bottom');
    }

    /**
     * Batalkan proses draft invoice.
     */
    public function toggleEditDraft()
    {
        $this->isEditingDraft = !$this->isEditingDraft;
    }

    public function cancelProcess(): void
    {
        $this->showConfirmationCard = false;
        $this->draftData = [];
        $this->isEditingDraft = false;

        $this->appendChatAndSave('assistant', "🚫 Proses draft invoice telah **dibatalkan**. Tidak ada data yang disimpan.\n\nJika Anda ingin membuat invoice baru atau mengubah data, silakan beritahu saya kapan saja.");

        $this->dispatch('scroll-to-bottom');
    }

    public function selectProject($id)
    {
        $this->selectedProjectId = $id;
        $this->loadChatHistory();
    }

    public function startEditProject($id, $name)
    {
        $this->editingProjectId = $id;
        $this->editingProjectName = $name;
    }

    public function saveProjectName()
    {
        if ($this->editingProjectId && trim($this->editingProjectName) !== '') {
            $project = Project::find($this->editingProjectId);
            if ($project) {
                $project->update(['project_name' => trim($this->editingProjectName)]);
            }
        }
        $this->editingProjectId = null;
        $this->editingProjectName = '';
    }

    public function cancelEditProject()
    {
        $this->editingProjectId = null;
        $this->editingProjectName = '';
    }

    public function deleteProject($id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->delete();
            if ($this->selectedProjectId === $id) {
                $this->startNewChat();
            }
        }
    }

    public function startNewChat()
    {
        $userId = Auth::id() ?? 1;
        ChatLog::where('user_id', $userId)
            ->whereNull('project_id')
            ->delete();

        $this->selectedProjectId = null;
        $this->loadChatHistory();
    }

    public function updatedPdfFile()
    {
        $this->validate([
            'pdfFile' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        $this->isProcessing = true;

        try {
            $userId = Auth::id() ?? 1;
            
            // Store the file
            $path = $this->pdfFile->store('documents', 'public');
            $filename = $this->pdfFile->getClientOriginalName();
            
            // Save to database
            $document = ProjectDocument::create([
                'user_id' => $userId,
                'project_id' => $this->selectedProjectId,
                'filename' => $filename,
                'file_path' => $path,
            ]);

            $absolutePath = storage_path('app/public/' . $path);
            
            // Process PDF with RagService
            $ragService = app(PdfRagService::class);
            $success = $ragService->processPdf($absolutePath, $filename, $this->selectedProjectId);
            
            if ($success) {
                $this->chatLogs[] = [
                    'role' => 'assistant',
                    'content' => "✅ Dokumen **{$filename}** berhasil diunggah dan dianalisis. Saya telah menghafalnya, silakan ajukan pertanyaan terkait dokumen ini.",
                ];
                Log::info("PDF Uploaded & Indexed to Chroma", ['filename' => $filename]);
            } else {
                throw new \Exception("Gagal menganalisis dokumen PDF. Pastikan file berupa teks bukan sekedar gambar scan.");
            }

        } catch (\Exception $e) {
            Log::error("Upload PDF Error: " . $e->getMessage());
            $this->chatLogs[] = [
                'role' => 'assistant',
                'content' => "❌ Gagal mengunggah PDF: " . $e->getMessage(),
            ];
        }

        $this->pdfFile = null;
        $this->isProcessing = false;
    }



    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        $userId = Auth::id() ?? 1;
        $query = Project::whereHas('client', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('client');

        if ($this->searchProject !== '') {
            $query->where('project_name', 'like', '%' . $this->searchProject . '%');
        }

        $activeProjects = $query->latest()->get();
        $activeProject = $this->selectedProjectId ? Project::with('client')->find($this->selectedProjectId) : null;

        return view('livewire.chat-workspace', [
            'activeProjects' => $activeProjects,
            'activeProject' => $activeProject,
        ]);
    }
}
