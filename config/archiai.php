<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ArchiAI Service Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi khusus untuk ArchiAI Service yang menggunakan
    | Featherless.ai sebagai provider AI (OpenAI-compatible API).
    |
    */

    // Model AI yang digunakan (DeepSeek via Featherless.ai)
    'model' => env('ARCHIAI_MODEL', 'deepseek-ai/DeepSeek-V4-Pro'),

    // Batas maksimum pesan dalam sliding window memory
    'max_history_messages' => env('ARCHIAI_MAX_HISTORY', 20),

];
