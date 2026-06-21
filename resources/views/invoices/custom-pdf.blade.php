<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .field-container {
            position: absolute;
            z-index: 10;
        }
    </style>
</head>
<body>
    <?php 
        // Helper to map values
        $values = [
            'client_name' => $client->client_name ?? '',
            'project_name' => $project->project_name ?? '',
            'invoice_number' => $invoice->invoice_number ?? '',
            'termin_name' => $invoice->termin_name ?? '',
            'percentage' => ($invoice->percentage ?? 0) . '%',
            'amount' => 'Rp ' . number_format($invoice->amount ?? 0, 0, ',', '.'),
            'date' => \Carbon\Carbon::parse($invoice->created_at)->format('d M Y'),
        ];
        
        $base64Image = '';
        // Using storage_path directly for DomPDF to access file
        $path = storage_path('app/public/' . $customTemplate->background_path);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
        }
    ?>

    @if($base64Image)
        <img src="{{ $base64Image }}" class="background" alt="Background">
    @endif

    @if($customTemplate->fields_mapping)
        @foreach($customTemplate->fields_mapping as $key => $style)
            @if(isset($values[$key]))
                <div class="field-container" style="
                    left: {{ $style['x'] ?? 0 }}%; 
                    top: {{ $style['y'] ?? 0 }}%; 
                    color: {{ $style['color'] ?? '#000000' }}; 
                    font-size: {{ $style['font_size'] ?? 14 }}px;
                ">
                    {{ $values[$key] }}
                </div>
            @endif
        @endforeach
    @endif
</body>
</html>
