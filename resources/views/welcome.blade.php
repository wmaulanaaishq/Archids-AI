<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArchiAgent - Micro CRM</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-slate-100 min-h-screen relative font-[Instrument_Sans]">
    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('background/background_archids.png') }}" class="w-full h-full object-cover" alt="Background" />
        <!-- Soft gradient overlay to ensure text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 to-teal-900/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-slate-900/30"></div>
    </div>

    <!-- Main Content Layer -->
    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        <header class="w-full">
            <nav class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-teal-400 transition-all duration-300 group-hover:bg-teal-500/20 group-hover:border-teal-400/40">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white drop-shadow-md">ArchiAgent</span>
                </div>
                
                <!-- Auth Links -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(255,255,255,0.05)] hover:shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-medium text-slate-200 hover:text-white transition-colors duration-300 drop-shadow-md">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-900 bg-gradient-to-r from-teal-400 to-cyan-400 hover:from-teal-300 hover:to-cyan-300 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(45,212,191,0.4)] hover:shadow-[0_0_25px_rgba(45,212,191,0.6)]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 flex items-center justify-center px-6">
            <div class="max-w-6xl w-full flex flex-col lg:flex-row items-center gap-16">
                <!-- Left Content -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-block mb-6 px-4 py-1.5 rounded-full bg-white/5 backdrop-blur-md border border-white/10 text-teal-300 text-xs font-semibold tracking-widest uppercase">
                        AI-Powered Micro CRM
                    </div>
                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold leading-[1.1] mb-6 text-white drop-shadow-lg">
                        Arsitektur Masa Depan, <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 to-cyan-400">Diotomatisasi.</span>
                    </h1>
                    <p class="text-lg lg:text-xl text-slate-300 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed drop-shadow-md font-light">
                        Ubah cara Anda mengelola klien, membuat invoice yang indah secara visual, dan memantau proyek dengan asisten kecerdasan buatan.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-900 font-bold rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(45,212,191,0.4)] hover:shadow-[0_0_30px_rgba(45,212,191,0.6)] hover:-translate-y-1">
                            Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white/5 hover:bg-white/15 backdrop-blur-md border border-white/10 text-white font-medium rounded-xl transition-all duration-300 hover:-translate-y-1">
                            Masuk ke Aplikasi
                        </a>
                    </div>
                </div>

                <!-- Right Feature Glass Panel -->
                <div class="hidden lg:block w-[440px] shrink-0">
                    <div class="bg-slate-900/40 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group">
                        <!-- Decorative glow -->
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-teal-500/20 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-150"></div>
                        
                        <div class="relative z-10 space-y-8">
                            <!-- Feature 1 -->
                            <div class="flex gap-5 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500/20 to-teal-500/5 border border-teal-500/30 flex items-center justify-center shrink-0 text-teal-400 shadow-[0_0_15px_rgba(45,212,191,0.2)]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white tracking-tight">AI-Drafted Invoices</h3>
                                    <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Buat invoice seketika melalui percakapan alami dengan AI ArchiAgent.</p>
                                </div>
                            </div>
                            <!-- Feature 2 -->
                            <div class="flex gap-5 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-cyan-500/5 border border-cyan-500/30 flex items-center justify-center shrink-0 text-cyan-400 shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white tracking-tight">Pixel-Perfect Templates</h3>
                                    <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Suntikkan data invoice AI langsung ke atas desain grafis karya Anda.</p>
                                </div>
                            </div>
                            <!-- Feature 3 -->
                            <div class="flex gap-5 items-start">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-indigo-500/5 border border-indigo-500/30 flex items-center justify-center shrink-0 text-indigo-400 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white tracking-tight">Project Context Memory</h3>
                                    <p class="text-sm text-slate-400 mt-1.5 leading-relaxed">Setiap proyek memiliki ruang obrolan terisolasi dan riwayat permanen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <footer class="w-full text-center py-6 text-slate-400/60 text-xs font-light relative z-10">
            &copy; {{ date('Y') }} ArchiAgent Micro-CRM. Crafted for visionary architects.
        </footer>
    </div>
</body>
</html>
