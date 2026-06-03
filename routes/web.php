<?php

use App\Livewire\ChatWorkspace;
use Illuminate\Support\Facades\Route;

Route::get('/', ChatWorkspace::class)->name('home');

// Placeholder route untuk download invoice PDF (Fase selanjutnya)
Route::get('/invoice/{invoice}/download', function (App\Models\Invoice $invoice) {
    // TODO: Implementasi PDF generation di fase berikutnya
    return response()->json([
        'message' => 'PDF generation belum diimplementasi.',
        'invoice' => $invoice->toArray(),
    ]);
})->name('invoice.download');
