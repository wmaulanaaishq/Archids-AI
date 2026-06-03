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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        studio: {
                            50:  '#e6f2f1',
                            100: '#b3d9d6',
                            200: '#80bfba',
                            300: '#4da69f',
                            400: '#268c83',
                            500: '#1a4d4a',
                            600: '#17443f',
                            700: '#133b35',
                            800: '#0f322b',
                            900: '#0a2920',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        }
    </script>

    <style>
        /* Custom scrollbar */
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: transparent; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        .chat-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Typing animation */
        @keyframes pulse-dot {
            0%, 80%, 100% { opacity: 0.3; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1); }
        }
        .typing-dot { animation: pulse-dot 1.4s ease-in-out infinite; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        /* Fade-in animation for chat bubbles */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }

        /* Slide-up animation for confirmation card */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slideUp 0.35s ease-out forwards; }

        /* Glassmorphism */
        .glass {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
        }

        /* Markdown prose styling for chat bubbles */
        .chat-prose p { margin: 0.4em 0; }
        .chat-prose p:first-child { margin-top: 0; }
        .chat-prose p:last-child { margin-bottom: 0; }
        .chat-prose strong { font-weight: 600; }
        .chat-prose em { font-style: italic; }
        .chat-prose ul, .chat-prose ol { margin: 0.5em 0; padding-left: 1.25em; }
        .chat-prose ul { list-style-type: disc; }
        .chat-prose ol { list-style-type: decimal; }
        .chat-prose li { margin: 0.15em 0; }
        .chat-prose code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85em;
            background: rgba(0,0,0,0.2);
            padding: 0.15em 0.35em;
            border-radius: 0.25em;
        }
        .chat-prose a { color: #6ee7b7; text-decoration: underline; }
        .chat-prose h1, .chat-prose h2, .chat-prose h3 { font-weight: 600; margin: 0.5em 0 0.25em; }
    </style>

    @livewireStyles
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
