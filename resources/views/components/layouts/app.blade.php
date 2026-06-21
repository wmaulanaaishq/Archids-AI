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
                            50:  '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    backgroundImage: {
                        'grid-pattern': "url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h40v40H0V0zm1 1h38v38H1V1z' fill='%23cbd5e1' fill-opacity='0.25' fill-rule='evenodd'/%3E%3C/svg%3E\")",
                    }
                },
            },
        }
    </script>

    <style>
        /* Custom scrollbar - Light Theme */
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: transparent; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .chat-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

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

        /* Glassmorphism - Liquid Light */
        .glass {
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
        }

        /* Markdown prose styling for chat bubbles (Light Theme) */
        .chat-prose p { margin: 0.4em 0; }
        .chat-prose p:first-child { margin-top: 0; }
        .chat-prose p:last-child { margin-bottom: 0; }
        .chat-prose strong { font-weight: 600; color: #1e293b; }
        .user-chat .chat-prose strong { color: #f8fafc; }
        
        .chat-prose em { font-style: italic; }
        .chat-prose ul, .chat-prose ol { margin: 0.5em 0; padding-left: 1.25em; }
        .chat-prose ul { list-style-type: disc; }
        .chat-prose ol { list-style-type: decimal; }
        .chat-prose li { margin: 0.15em 0; }
        .chat-prose code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85em;
            background: rgba(0,0,0,0.06);
            padding: 0.15em 0.35em;
            border-radius: 0.25em;
        }
        .user-chat .chat-prose code { background: rgba(255,255,255,0.2); }
        
        .chat-prose a { color: #2563eb; text-decoration: underline; }
        .user-chat .chat-prose a { color: #93c5fd; }
        
        .chat-prose h1, .chat-prose h2, .chat-prose h3 { font-weight: 600; margin: 0.5em 0 0.25em; color: #1e293b; }
        .user-chat .chat-prose h1, .user-chat .chat-prose h2, .user-chat .chat-prose h3 { color: #f8fafc; }
    </style>

    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased relative overflow-hidden selection:bg-slate-200 selection:text-slate-900">
    <!-- Subtle Grid Background -->
    <div class="absolute inset-0 bg-grid-pattern z-0 pointer-events-none"></div>
    
    <!-- Ambient Glow / Blur Orbs -->
    <div class="absolute top-[-15%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-slate-200/50 blur-[120px] z-0 pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[40vw] h-[40vw] rounded-full bg-slate-200/50 blur-[100px] z-0 pointer-events-none"></div>

    <div class="relative z-10 flex-grow flex flex-col h-screen">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>
