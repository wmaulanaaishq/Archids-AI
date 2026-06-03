<?php

use App\Http\Controllers\InvoiceController;
use App\Livewire\ChatWorkspace;
use Illuminate\Support\Facades\Route;

Route::get('/', ChatWorkspace::class)->name('home');

Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])
    ->name('invoice.download');
