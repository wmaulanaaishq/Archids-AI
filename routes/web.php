<?php

use App\Http\Controllers\InvoiceController;
use App\Livewire\ChatWorkspace;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', ChatWorkspace::class)->name('chat');
    
    Route::get('/settings/template', \App\Livewire\Settings\TemplateManager::class)->name('settings.template');

    Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])
        ->name('invoice.download');
});
