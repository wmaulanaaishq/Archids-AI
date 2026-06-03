<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Download invoice sebagai file PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        // 1. Ambil invoice beserta relasi project → client → user
        $invoice = Invoice::with(['project.client'])->findOrFail($id);

        $project = $invoice->project;
        $client = $project->client;

        // 2. Dapatkan user_id (dari relasi client, atau fallback ke auth/default)
        $userId = $client->user_id ?? Auth::id() ?? 1;

        // 3. Ambil invoice_settings milik user
        $settings = InvoiceSetting::where('user_id', $userId)->first();

        // Jika belum ada settings, buat default
        if (!$settings) {
            $settings = (object) [
                'template_theme' => 'monospace_minimal',
                'primary_color' => '#1a4d4a',
                'studio_logo' => null,
                'payment_terms' => "Transfer ke rekening:\nBank BCA\nNo. Rek: 123-456-7890\na.n. Studio Arsitektur",
            ];
        }

        // 4. Siapkan data untuk view PDF
        $data = [
            'invoice' => $invoice,
            'project' => $project,
            'client' => $client,
            'settings' => $settings,
            'primaryColor' => $settings->primary_color ?: '#1a4d4a',
        ];

        // 5. Generate PDF
        $pdf = Pdf::loadView('invoices.pdf', $data);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'invoice-' . $invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }
}
