<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* ============================================= */
        /* MONOSPACE MINIMALIST — ARCHITECT INVOICE      */
        /* ============================================= */

        @page {
            margin: 40px 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
            background: #ffffff;
        }

        /* ---- Utility ---- */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-accent { color: {{ $primaryColor }}; }
        .text-muted { color: #777777; }
        .text-bold { font-weight: bold; }
        .text-large { font-size: 24px; letter-spacing: 3px; }
        .text-medium { font-size: 14px; }
        .text-small { font-size: 9px; }
        .text-upper { text-transform: uppercase; letter-spacing: 2px; }

        .border-accent { border-color: {{ $primaryColor }}; }

        .mt-5 { margin-top: 5px; }
        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .mt-20 { margin-top: 20px; }
        .mt-30 { margin-top: 30px; }
        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }

        /* ---- Dashed Separator ---- */
        .separator {
            border: none;
            border-top: 1px dashed {{ $primaryColor }};
            margin: 18px 0;
        }

        .separator-thin {
            border: none;
            border-top: 1px dashed #cccccc;
            margin: 12px 0;
        }

        .separator-solid {
            border: none;
            border-top: 2px solid {{ $primaryColor }};
            margin: 15px 0;
        }

        /* ---- Outer Frame ---- */
        .invoice-frame {
            border: 2px solid {{ $primaryColor }};
            padding: 30px 35px;
            position: relative;
        }

        .invoice-frame::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border: 1px solid {{ $primaryColor }};
            opacity: 0.3;
            pointer-events: none;
        }

        /* ---- Tables ---- */
        .full-width { width: 100%; }
        .no-border { border: none; border-collapse: collapse; }
        .no-border td, .no-border th { border: none; padding: 2px 0; vertical-align: top; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th {
            background-color: {{ $primaryColor }};
            color: #ffffff;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
        }
        .data-table td {
            padding: 10px 10px;
            border-bottom: 1px dashed #dddddd;
            font-size: 11px;
            vertical-align: middle;
        }
        .data-table tr:last-child td {
            border-bottom: 2px solid {{ $primaryColor }};
        }

        /* ---- Amount Highlight ---- */
        .amount-box {
            background-color: {{ $primaryColor }};
            color: #ffffff;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: right;
        }

        /* ---- Footer Area ---- */
        .footer-box {
            border: 1px dashed {{ $primaryColor }};
            padding: 12px 15px;
            font-size: 10px;
            line-height: 1.6;
        }

        .stamp-box {
            border: 2px solid {{ $primaryColor }};
            width: 180px;
            height: 80px;
            text-align: center;
            padding-top: 25px;
            font-size: 9px;
            color: #999999;
            letter-spacing: 1px;
        }

        .label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999999;
            font-weight: bold;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

<div class="invoice-frame">

    <!-- ============================================= -->
    <!-- HEADER: Studio Name + Invoice Number          -->
    <!-- ============================================= -->
    <table class="full-width no-border">
        <tr>
            <td style="width: 55%; vertical-align: top;">
                @if($settings->studio_logo)
                    <img src="{{ public_path('storage/' . $settings->studio_logo) }}" style="max-height: 45px; margin-bottom: 8px;" alt="Logo">
                    <br>
                @endif
                <span class="text-upper text-accent text-medium text-bold">STUDIO ARSITEKTUR</span>
                <br>
                <span class="text-muted text-small">Architecture · Interior · Landscape</span>
            </td>
            <td style="width: 45%; text-align: right; vertical-align: top;">
                <span class="label">INVOICE NO.</span>
                <br>
                <span class="text-large text-accent text-bold">{{ $invoice->invoice_number }}</span>
            </td>
        </tr>
    </table>

    <hr class="separator-solid">

    <!-- ============================================= -->
    <!-- META: Date + Status                           -->
    <!-- ============================================= -->
    <table class="full-width no-border">
        <tr>
            <td style="width: 50%;">
                <span class="label">Tanggal Cetak</span>
                <br>
                <span class="text-bold">{{ now()->translatedFormat('d F Y') }}</span>
            </td>
            <td style="width: 50%; text-align: right;">
                <span class="label">Status</span>
                <br>
                <span class="text-bold" style="
                    color: #ffffff;
                    background-color: {{ $invoice->status === 'Lunas' ? '#16a34a' : '#d97706' }};
                    padding: 3px 12px;
                    font-size: 10px;
                    letter-spacing: 1.5px;
                ">{{ strtoupper($invoice->status) }}</span>
            </td>
        </tr>
    </table>

    <hr class="separator">

    <!-- ============================================= -->
    <!-- BILL TO: Client + Project Info                -->
    <!-- ============================================= -->
    <table class="full-width no-border">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <span class="label">Ditagihkan Kepada</span>
                <div class="mt-5">
                    <span class="text-medium text-bold">{{ $client->client_name }}</span>
                    <br>
                    <span class="text-muted" style="font-size: 10px;">{{ $client->phone_number !== '-' ? $client->phone_number : '' }}</span>
                    @if($client->project_address !== '-')
                        <br>
                        <span class="text-muted" style="font-size: 10px;">{{ $client->project_address }}</span>
                    @endif
                </div>
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <span class="label">Detail Proyek</span>
                <div class="mt-5">
                    <span class="text-medium text-bold">{{ $project->project_name }}</span>
                    <br>
                    <span class="text-muted" style="font-size: 10px;">
                        Nilai Kontrak: Rp {{ number_format($project->total_contract_value, 0, ',', '.') }}
                    </span>
                    <br>
                    <span class="text-muted" style="font-size: 10px;">
                        Status: {{ $project->status }}
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <hr class="separator">

    <!-- ============================================= -->
    <!-- INVOICE DETAIL TABLE                          -->
    <!-- ============================================= -->
    <span class="label">Rincian Tagihan</span>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Deskripsi Termin</th>
                <th style="width: 20%; text-align: center;">Persentase</th>
                <th style="width: 35%; text-align: right;">Jumlah (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>
                    <span class="text-bold">{{ $invoice->termin_name }}</span>
                    <br>
                    <span class="text-muted text-small">Proyek: {{ $project->project_name }}</span>
                </td>
                <td style="text-align: center;">
                    <span class="text-bold text-accent" style="font-size: 16px;">{{ $invoice->percentage }}%</span>
                </td>
                <td style="text-align: right;">
                    <span class="text-bold" style="font-size: 13px;">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ============================================= -->
    <!-- TOTAL AMOUNT                                  -->
    <!-- ============================================= -->
    <table class="full-width no-border mt-10">
        <tr>
            <td style="width: 55%;"></td>
            <td style="width: 45%;">
                <table class="full-width no-border">
                    <tr>
                        <td style="padding: 5px 10px;">
                            <span class="text-muted text-small text-upper">Subtotal</span>
                        </td>
                        <td style="text-align: right; padding: 5px 10px;">
                            Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px;">
                            <span class="text-muted text-small text-upper">Pajak</span>
                        </td>
                        <td style="text-align: right; padding: 5px 10px;">
                            <span class="text-muted">—</span>
                        </td>
                    </tr>
                </table>
                <div class="amount-box">
                    TOTAL &nbsp;&nbsp; Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="separator">

    <!-- ============================================= -->
    <!-- PAYMENT TERMS + SIGNATURE                     -->
    <!-- ============================================= -->
    <table class="full-width no-border">
        <tr>
            <td style="width: 55%; vertical-align: top;">
                <span class="label">Informasi Pembayaran</span>
                <div class="footer-box mt-5">
                    {!! nl2br(e($settings->payment_terms ?? "Transfer ke rekening:\nBank BCA\nNo. Rek: 123-456-7890\na.n. Studio Arsitektur")) !!}
                </div>

                <div class="mt-15">
                    <span class="label">Catatan</span>
                    <div class="mt-5 text-muted" style="font-size: 9px; line-height: 1.6;">
                        • Invoice ini berlaku sebagai bukti tagihan resmi.<br>
                        • Pembayaran dianggap sah setelah dana diterima.<br>
                        • Harap konfirmasi setelah melakukan transfer.
                    </div>
                </div>
            </td>
            <td style="width: 45%; text-align: center; vertical-align: top; padding-left: 30px;">
                <span class="label">Hormat Kami,</span>
                <div class="mt-15" style="margin-left: auto; margin-right: auto;">
                    <div class="stamp-box" style="margin: 0 auto;">
                        <span class="text-upper" style="color: #cccccc; font-size: 8px;">Tanda Tangan<br>& Stempel</span>
                    </div>
                </div>
                <div class="mt-10">
                    <hr style="border: none; border-top: 1px solid #333333; width: 180px; margin: 0 auto;">
                    <span class="text-bold text-small text-upper" style="margin-top: 5px; display: inline-block;">
                        Studio Arsitektur
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <hr class="separator-thin" style="margin-top: 25px;">

    <!-- ============================================= -->
    <!-- BOTTOM FOOTER                                 -->
    <!-- ============================================= -->
    <table class="full-width no-border">
        <tr>
            <td class="text-center text-muted text-small" style="padding-top: 5px; letter-spacing: 1.5px;">
                GENERATED BY ARCHIAGENT · MICRO-CRM FOR FREELANCE ARCHITECTS
            </td>
        </tr>
        <tr>
            <td class="text-center text-muted" style="font-size: 8px; padding-top: 3px; letter-spacing: 1px;">
                {{ $invoice->invoice_number }} · {{ now()->format('d/m/Y H:i') }} · Halaman 1 dari 1
            </td>
        </tr>
    </table>

</div>

</body>
</html>
