<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ArchiAgent - Micro-CRM berbasis AI Agent untuk Freelance Arsitek">
    <title>{{ $title ?? 'ArchiAgent — AI Invoice Assistant' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600&family=JetBrains+Mono:wght@400;500;700&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Geist', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                        display: ['Space Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            green: '#99FF66', // Vibrant Electric Lime
                            dark: '#000000',
                            light: '#FFFFFF',
                            surface: '#f9f9f9',
                        }
                    },
                    boxShadow: {
                        'brutal': '4px 4px 0px 0px rgba(0,0,0,1)',
                        'brutal-hover': '2px 2px 0px 0px rgba(0,0,0,1)',
                        'brutal-active': '0px 0px 0px 0px rgba(0,0,0,1)',
                        'brutal-lg': '8px 8px 0px 0px rgba(0,0,0,1)',
                    }
                },
            },
        }
    </script>
    
    <style>
        /* Base Reset for Neobrutalism */
        * {
            border-radius: 0 !important; /* Force sharp corners */
        }
        
        .border-brutal {
            border: 2px solid #000;
        }
        
        .border-brutal-thick {
            border: 4px solid #000;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-white text-brand-dark font-sans antialiased min-h-screen flex flex-col relative selection:bg-brand-green selection:text-black">
    <!-- Pure white background, no overlays -->
    
    <!-- Main Content Layer -->
    <div class="relative z-10 flex-grow flex flex-col min-h-screen">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>
