<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArchiAIService
{
    /**
     * System prompt yang menginstruksikan AI sebagai asisten invoice arsitek.
     */
    private string $systemPrompt;

    /**
     * Definisi tool (Function Calling) untuk ekstraksi data invoice.
     */
    private array $tools;

    /**
     * Batas maksimum pesan dalam sliding window memory.
     */
    private int $maxHistoryMessages;

    /**
     * Base URL API.
     */
    private string $baseUrl;

    /**
     * API Key.
     */
    private string $apiKey;

    /**
     * Model AI yang digunakan.
     */
    private string $model;

    public function __construct()
    {
        $this->maxHistoryMessages = (int) config('archiai.max_history_messages', 20);
        $this->baseUrl = rtrim(config('openai.base_uri', 'https://api.featherless.ai/v1'), '/');
        $this->apiKey = config('openai.api_key', '');
        $this->model = config('archiai.model', 'deepseek-ai/DeepSeek-V4-Pro');

        $this->systemPrompt = <<<'PROMPT'
Kamu adalah ArchiAgent, asisten AI cerdas untuk arsitek freelance Indonesia.
Tugasmu adalah membantu arsitek membuat draft invoice melalui percakapan natural bahasa Indonesia.

ALUR KERJA:
1. Sapa user dan tanyakan informasi yang dibutuhkan untuk membuat invoice.
2. Kumpulkan data berikut secara bertahap melalui percakapan:
   - Nama klien (contoh: "Pak Andi", "Bu Sari")
   - Nama proyek (contoh: "Desain Rumah Minimalis Semarang")
   - Nomor invoice (contoh: "INV-001", "INV-002")
   - Nama termin (contoh: "Termin I / DP", "Termin II / Pra-Desain")
   - Persentase termin (angka bulat tanpa simbol %, contoh: 30)
   - Jumlah nominal (angka bersih tanpa titik, koma, atau "Rp", contoh: 6585900)

3. Jika user memberikan nominal dengan format "Rp 6.585.900" atau "6.585.900",
   kamu HARUS mengkonversinya menjadi angka bersih: 6585900.
4. Jika user memberikan persentase dengan simbol %, hilangkan simbolnya.
   Contoh: "30%" menjadi 30.

ATURAN PENTING:
- Jangan pernah membuat data fiktif. Selalu tanya jika ada yang kurang.
- Setelah SEMUA 6 data terkumpul lengkap, panggil fungsi `prepare_invoice_draft`.
- Jika data belum lengkap, lanjutkan percakapan untuk mengumpulkan data yang kurang.
- Selalu konfirmasi ulang data sebelum memanggil fungsi.
- Gunakan bahasa Indonesia yang sopan dan profesional.
PROMPT;

        $this->tools = [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'prepare_invoice_draft',
                    'description' => 'Membuat draft invoice ketika semua data yang diperlukan sudah terkumpul lengkap dari percakapan dengan user.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'client_name' => [
                                'type' => 'string',
                                'description' => 'Nama lengkap klien, contoh: "Pak Andi", "Bu Sari"',
                            ],
                            'project_name' => [
                                'type' => 'string',
                                'description' => 'Nama proyek arsitektur, contoh: "Desain Rumah Minimalis Semarang"',
                            ],
                            'invoice_number' => [
                                'type' => 'string',
                                'description' => 'Nomor invoice, contoh: "INV-001", "INV-002"',
                            ],
                            'termin_name' => [
                                'type' => 'string',
                                'description' => 'Nama termin pembayaran, contoh: "Termin I / DP", "Termin II / Pra-Desain"',
                            ],
                            'percentage' => [
                                'type' => 'integer',
                                'description' => 'Persentase termin dalam angka bulat tanpa simbol persen, contoh: 30',
                            ],
                            'amount' => [
                                'type' => 'integer',
                                'description' => 'Nominal uang bersih tanpa titik, koma, atau Rp, contoh: 6585900',
                            ],
                        ],
                        'required' => [
                            'client_name',
                            'project_name',
                            'invoice_number',
                            'termin_name',
                            'percentage',
                            'amount',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Proses pesan chat user dengan sliding window memory dan function calling.
     *
     * @param  string  $userMessage   Pesan terbaru dari user.
     * @param  array   $chatHistory   Riwayat chat sebelumnya (format: [['role' => '...', 'content' => '...'], ...]).
     * @return array   Response berupa ['type' => 'message'|'function_call', 'data' => ...]
     */
    public function processChat(string $userMessage, array $chatHistory = []): array
    {
        // === 1. Bangun messages dengan sliding window memory ===
        $messages = $this->buildMessages($userMessage, $chatHistory);

        try {
            // === 2. Kirim request ke Featherless.ai via HTTP Client ===
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout((int) config('openai.request_timeout', 60))
            ->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => $messages,
                'tools' => $this->tools,
                'tool_choice' => 'auto',
                'temperature' => 0.3,
                'max_tokens' => 1024,
            ]);

            if (!$response->successful()) {
                Log::error('ArchiAI API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'type' => 'message',
                    'data' => [
                        'content' => 'Maaf, terjadi kesalahan koneksi ke server AI. Silakan coba lagi.',
                        'role' => 'assistant',
                    ],
                ];
            }

            $body = $response->json();
            $choice = $body['choices'][0] ?? null;

            if (!$choice) {
                return [
                    'type' => 'message',
                    'data' => [
                        'content' => 'Maaf, tidak ada respons dari AI. Silakan coba lagi.',
                        'role' => 'assistant',
                    ],
                ];
            }

            // === 3. Cek apakah AI memanggil function (tool call) ===
            $finishReason = $choice['finish_reason'] ?? '';
            $toolCalls = $choice['message']['tool_calls'] ?? [];

            if ($finishReason === 'tool_calls' && !empty($toolCalls)) {
                return $this->handleToolCall($toolCalls[0]);
            }

            // === 4. Jika bukan function call, kembalikan pesan teks biasa ===
            return [
                'type' => 'message',
                'data' => [
                    'content' => $choice['message']['content'] ?? '',
                    'role' => 'assistant',
                ],
            ];

        } catch (\Exception $e) {
            Log::error('ArchiAIService Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'type' => 'message',
                'data' => [
                    'content' => 'Maaf, terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.',
                    'role' => 'assistant',
                ],
            ];
        }
    }

    /**
     * Bangun array messages dengan sliding window memory.
     *
     * @param  string  $userMessage
     * @param  array   $chatHistory
     * @return array
     */
    private function buildMessages(string $userMessage, array $chatHistory): array
    {
        // System prompt selalu di posisi pertama
        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt],
        ];

        // Terapkan sliding window: ambil N pesan terakhir dari history
        if (!empty($chatHistory)) {
            $windowedHistory = array_slice($chatHistory, -$this->maxHistoryMessages);
            $messages = array_merge($messages, $windowedHistory);
        }

        // Tambahkan pesan terbaru dari user
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        return $messages;
    }

    /**
     * Handle tool call response dari AI dan decode argumen JSON.
     *
     * @param  array  $toolCall
     * @return array
     */
    private function handleToolCall(array $toolCall): array
    {
        // Featherless.ai kadang mengembalikan name: null pada tool_call,
        // maka kita fallback ke nama tool yang kita definisikan.
        $functionName = $toolCall['function']['name'] ?? 'prepare_invoice_draft';
        $rawArguments = $toolCall['function']['arguments'] ?? '{}';

        Log::info('ArchiAI Function Call', [
            'function' => $functionName,
            'raw_arguments' => $rawArguments,
        ]);

        // Decode JSON arguments menjadi array PHP
        $arguments = json_decode($rawArguments, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('ArchiAI JSON Decode Error', [
                'error' => json_last_error_msg(),
                'raw' => $rawArguments,
            ]);

            return [
                'type' => 'message',
                'data' => [
                    'content' => 'Maaf, terjadi kesalahan saat memproses data invoice. Silakan ulangi informasinya.',
                    'role' => 'assistant',
                ],
            ];
        }

        // Pastikan amount dan percentage adalah integer
        if (isset($arguments['amount'])) {
            $arguments['amount'] = (int) $arguments['amount'];
        }
        if (isset($arguments['percentage'])) {
            $arguments['percentage'] = (int) $arguments['percentage'];
        }

        return [
            'type' => 'function_call',
            'data' => [
                'function' => $functionName,
                'arguments' => $arguments,
            ],
        ];
    }
}
