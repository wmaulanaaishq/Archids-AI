<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Services\ArchiAIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('ArchiAgent — AI Invoice Assistant')]
class ChatWorkspace extends Component
{
    /**
     * Input pesan dari user.
     */
    public string $message = '';

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
     * Flag loading state.
     */
    public bool $isProcessing = false;

    /**
     * Mount: tambahkan pesan selamat datang dari AI.
     */
    public function mount(): void
    {
        $this->chatLogs[] = [
            'role' => 'assistant',
            'content' => "Halo! 👋 Saya **ArchiAgent**, asisten AI Anda untuk membuat invoice proyek arsitektur.\n\nSilakan ceritakan detail invoice yang ingin Anda buat. Saya butuh informasi berikut:\n\n• Nama klien\n• Nama proyek\n• Nomor invoice\n• Nama termin\n• Persentase termin\n• Nominal pembayaran\n\nAnda bisa menyebutkan semuanya sekaligus atau satu per satu — saya akan memandu Anda. 😊",
        ];
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

        // 1. Masukkan pesan user ke chatLogs
        $this->chatLogs[] = [
            'role' => 'user',
            'content' => $trimmed,
        ];

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

            // 3. Panggil ArchiAIService
            $service = app(ArchiAIService::class);
            $result = $service->processChat($userMessage, $historyForAI);

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
                $this->chatLogs[] = [
                    'role' => 'assistant',
                    'content' => $result['data']['content'] ?? 'Maaf, saya tidak dapat memproses permintaan Anda.',
                ];
            }
        } catch (\Exception $e) {
            Log::error('ChatWorkspace sendMessage Error', [
                'message' => $e->getMessage(),
            ]);

            $this->chatLogs[] = [
                'role' => 'assistant',
                'content' => '⚠️ Maaf, terjadi kesalahan saat menghubungi server AI. Silakan coba lagi dalam beberapa saat.',
            ];
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

            // 5. Reset state konfirmasi
            $this->showConfirmationCard = false;
            $this->draftData = [];

            // 6. Tambahkan pesan sukses dengan link download
            $downloadUrl = route('invoice.download', $invoice->id);
            $formattedAmount = 'Rp ' . number_format($invoice->amount, 0, ',', '.');

            $this->chatLogs[] = [
                'role' => 'assistant',
                'content' => "✅ **Invoice berhasil disimpan!**\n\n"
                    . "📄 **{$invoice->invoice_number}** — {$invoice->termin_name}\n"
                    . "💰 Nominal: **{$formattedAmount}**\n"
                    . "📊 Status: **Pending**\n\n"
                    . "Silakan unduh invoice Anda melalui tombol di bawah ini.",
                'download_url' => $downloadUrl,
            ];

        } catch (\Exception $e) {
            Log::error('ChatWorkspace confirmAndSave Error', [
                'message' => $e->getMessage(),
                'draft_data' => $this->draftData,
            ]);

            $this->chatLogs[] = [
                'role' => 'assistant',
                'content' => '⚠️ Maaf, terjadi kesalahan saat menyimpan invoice. Silakan coba lagi.',
            ];
        }

        $this->dispatch('scroll-to-bottom');
    }

    /**
     * Batalkan proses draft invoice.
     */
    public function cancelProcess(): void
    {
        $this->showConfirmationCard = false;
        $this->draftData = [];

        $this->chatLogs[] = [
            'role' => 'assistant',
            'content' => "🚫 Proses draft invoice telah **dibatalkan**. Tidak ada data yang disimpan.\n\nJika Anda ingin membuat invoice baru atau mengubah data, silakan beritahu saya kapan saja.",
        ];

        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.chat-workspace');
    }
}
