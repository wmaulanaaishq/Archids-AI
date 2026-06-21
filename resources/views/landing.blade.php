<x-layouts.guest title="ArchiAgent — Micro-CRM & AI Invoice untuk Arsitek">
    <!-- Navigation -->
    <header class="w-full bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="ArchiAgent Logo" class="w-14 h-14 object-contain" />
                </div>
                <span class="text-xl font-display font-bold tracking-tighter text-black uppercase">ArchiAgent</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="https://github.com/wmaulanaaishq/Archids-AI" target="_blank" class="hidden sm:inline-block px-5 py-2 text-sm font-medium text-black border-2 border-black bg-white hover:bg-gray-50 transition-colors">
                    Source Code
                </a>
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-black bg-brand-green border-2 border-black hover:brightness-105 transition-all">
                    Get Started
                </a>
            </div>
        </nav>
    </header>

    <main class="flex-1 w-full flex flex-col overflow-hidden">
        
        {{-- ═══════════════════════════════════════════ --}}
        {{-- HERO SECTION --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full relative overflow-hidden min-h-[92vh] flex flex-col items-center bg-gradient-to-b from-white via-white to-green-50/40">
            <!-- Text content -->
            <!-- Text content -->
            <div class="relative z-10 w-full max-w-5xl mx-auto px-6 pt-20 md:pt-28 pb-8 text-center flex flex-col items-center gap-6">
                <h1 class="text-5xl md:text-6xl lg:text-6xl font-display font-bold text-black tracking-tight leading-[1.15] w-full">
                    <span class="block">Ruang untuk Berkreasi.</span>
                    <span class="block">Bukan untuk Administrasi.</span>
                </h1>
                <p class="text-base md:text-lg lg:text-xl text-gray-600 font-sans font-normal max-w-2xl mx-auto leading-relaxed">
                    ArchiAgent adalah asisten AI pintar yang mengerti cara Anda bekerja. Otomatisasi <i>invoice</i> dari obrolan singkat, analisis dokumen PDF proyek seketika, dan kelola klien tanpa kerumitan.
                </p>
                <div class="flex flex-row items-center justify-center gap-4 mt-2">
                    <a href="{{ route('login') }}" class="group px-7 py-3 bg-brand-green border-2 border-black text-black font-semibold text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Mulai Gratis &rarr;
                    </a>
                    <a href="https://github.com/wmaulanaaishq/Archids-AI" target="_blank" class="px-7 py-3 bg-white border-2 border-black text-black font-semibold text-sm shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Source Code
                    </a>
                </div>
            </div>
            <!-- Hero illustration — sits at the bottom half only, fades at the top -->
            <div class="absolute bottom-0 left-0 right-0 h-[55%] z-0 pointer-events-none" style="-webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 30%); mask-image: linear-gradient(to bottom, transparent 0%, black 30%);">
                <img src="{{ asset('background/background_archids.png') }}" alt="ArchiAgent Illustration" class="absolute left-1/2 -translate-x-1/2 bottom-0 w-[max(1400px,100vw)] h-auto object-cover" />
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- THE SOLUTION --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section id="the-solution" class="w-full bg-white py-24 md:py-32 px-6 relative">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10 md:gap-6">
                <!-- Character cropped & blended -->
                <div class="w-full md:w-1/2 relative flex justify-center overflow-hidden" style="min-height: 420px;">
                    <div class="absolute inset-0" style="-webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%);">
                        <img src="{{ asset('backgroud_asset/hero2.png') }}" alt="ArchiBot mendesain" class="w-full h-full object-contain" />
                    </div>
                </div>
                <!-- Text -->
                <div class="w-full md:w-1/2 flex flex-col gap-5">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">The Solution</span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.7rem] font-display font-bold text-black tracking-tight leading-[1.15]">
                        Asisten pribadi yang mengerti bahasa arsitek.
                    </h2>
                    <p class="text-gray-500 leading-relaxed">
                        ArchiAgent adalah micro-CRM berbasis AI yang dirancang khusus untuk arsitek freelance. Cukup jelaskan detail proyek melalui percakapan alami — AI mengekstrak data klien, item pekerjaan, dan harga secara otomatis.
                    </p>
                    <p class="text-gray-500 leading-relaxed">
                        Tidak perlu lagi spreadsheet atau form manual. ArchiAgent mengubah obrolan menjadi invoice profesional dalam hitungan detik.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-black mt-2 group">
                        <span class="border-b-2 border-brand-green group-hover:border-black transition-colors">Pelajari lebih lanjut</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- AI INVOICE --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full bg-gradient-to-br from-gray-50 to-green-50/30 py-24 md:py-32 px-6 border-t border-gray-100 relative overflow-hidden">
            <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center gap-10 md:gap-6">
                <!-- Text -->
                <div class="w-full md:w-1/2 flex flex-col gap-5">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">AI-Drafted Invoices</span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.7rem] font-display font-bold text-black tracking-tight leading-[1.15]">
                        Dari percakapan menjadi invoice profesional.
                    </h2>
                    <p class="text-gray-500 leading-relaxed">
                        Jelaskan proyek Anda ke AI — mulai dari desain konsep, gambar kerja, hingga rendering 3D. ArchiAgent mengekstrak item pekerjaan, menghitung biaya, dan menghasilkan invoice PDF siap kirim.
                    </p>
                    <div class="border-l-[3px] border-brand-green pl-5 mt-3 bg-white/60 py-4 pr-4">
                        <p class="text-gray-500 text-sm italic leading-relaxed">
                            "Dulu saya butuh 2 jam untuk membuat satu invoice. Sekarang cukup ngobrol 5 menit dengan ArchiBot, invoice langsung jadi — lengkap dengan item, harga, dan pajak."
                        </p>
                        <p class="text-black font-bold text-sm mt-3">— Arsitek Freelance, Jakarta</p>
                    </div>
                </div>
                <!-- Character cropped & blended -->
                <div class="w-full md:w-1/2 relative flex justify-center overflow-hidden" style="min-height: 420px;">
                    <div class="absolute inset-0" style="-webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%);">
                        <img src="{{ asset('backgroud_asset/hero3.png') }}" alt="ArchiBot membuat invoice" class="w-full h-full object-contain" />
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- FEATURES GRID --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section id="features" class="w-full bg-white py-24 md:py-32 px-6 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">Fitur Utama</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-black tracking-tight mt-3 mb-4">Semua yang arsitek butuhkan.</h2>
                    <p class="text-gray-500 text-base max-w-lg mx-auto">Dari manajemen klien hingga invoice otomatis — dirancang untuk alur kerja arsitek sesungguhnya.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Feature 1 -->
                    <div class="group bg-white border-2 border-gray-200 p-8 hover:border-black hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all duration-300 flex flex-col h-full">
                        <div class="w-12 h-12 bg-brand-green border-2 border-black flex items-center justify-center mb-6 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] group-hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] group-hover:translate-x-[1px] group-hover:translate-y-[1px] transition-all">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">AI Chat-to-Invoice</h3>
                        <p class="text-gray-500 text-sm flex-grow leading-relaxed">Ngobrol dengan AI, jelaskan proyek, dan invoice otomatis terbuat. Tidak perlu form, tidak perlu spreadsheet.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="group bg-white border-2 border-gray-200 p-8 hover:border-black hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all duration-300 flex flex-col h-full">
                        <div class="w-12 h-12 bg-[#FFD6E8] border-2 border-black flex items-center justify-center mb-6 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] group-hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] group-hover:translate-x-[1px] group-hover:translate-y-[1px] transition-all">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">Blueprint-Style PDF</h3>
                        <p class="text-gray-500 text-sm flex-grow leading-relaxed">Invoice PDF bergaya blueprint arsitektur. Tampil unik dan profesional di mata klien Anda.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="group bg-white border-2 border-gray-200 p-8 hover:border-black hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] transition-all duration-300 flex flex-col h-full">
                        <div class="w-12 h-12 bg-[#D6E8FF] border-2 border-black flex items-center justify-center mb-6 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] group-hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] group-hover:translate-x-[1px] group-hover:translate-y-[1px] transition-all">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">Manajemen Proyek</h3>
                        <p class="text-gray-500 text-sm flex-grow leading-relaxed">Setiap proyek punya ruang obrolan terisolasi. AI mengingat semua detail, timeline, dan riwayat.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- MICRO-CRM --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full bg-gradient-to-bl from-gray-50 to-green-50/20 py-24 md:py-32 px-6 border-t border-gray-100 relative overflow-hidden">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10 md:gap-6">
                <!-- Character cropped & blended -->
                <div class="w-full md:w-[55%] relative flex justify-center overflow-hidden" style="min-height: 460px;">
                    <div class="absolute inset-0" style="-webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%);">
                        <img src="{{ asset('backgroud_asset/hero4.png') }}" alt="ArchiBot CRM dashboard" class="w-full h-full object-contain" />
                    </div>
                </div>
                <!-- Text -->
                <div class="w-full md:w-[45%] flex flex-col gap-5">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">Micro-CRM</span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.7rem] font-display font-bold text-black tracking-tight leading-[1.15]">
                        Kelola klien dan proyek dalam satu dashboard.
                    </h2>
                    <p class="text-gray-500 leading-relaxed">
                        Tidak hanya invoice. ArchiAgent mengelola data klien, progres proyek, riwayat obrolan, dan jadwal pembayaran dalam satu antarmuka intuitif.
                    </p>
                    <ul class="space-y-4 mt-2">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-brand-green border-2 border-black flex items-center justify-center flex-shrink-0 mt-0.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                <svg class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-gray-600 text-sm leading-relaxed">Daftar klien dengan status aktif, timeline, dan riwayat proyek lengkap</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-brand-green border-2 border-black flex items-center justify-center flex-shrink-0 mt-0.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                <svg class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-gray-600 text-sm leading-relaxed">Percakapan AI per-proyek dengan konteks tersimpan permanen</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-brand-green border-2 border-black flex items-center justify-center flex-shrink-0 mt-0.5 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                <svg class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-gray-600 text-sm leading-relaxed">Drag &amp; Drop posisi data di atas template invoice kustom Anda</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- PROJECT MONITORING --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full bg-white py-24 md:py-32 px-6 border-t border-gray-100 relative overflow-hidden">
            <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center gap-10 md:gap-6">
                <!-- Text -->
                <div class="w-full md:w-1/2 flex flex-col gap-5">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">Project Monitoring</span>
                    <h2 class="text-3xl md:text-4xl lg:text-[2.7rem] font-display font-bold text-black tracking-tight leading-[1.15]">
                        Pantau progres proyek secara real-time.
                    </h2>
                    <p class="text-gray-500 leading-relaxed">
                        Dari tahap desain konsep hingga serah terima, ArchiAgent melacak setiap milestone proyek arsitektur. AI mendeteksi fase yang sedang berjalan berdasarkan percakapan dan dokumen Anda.
                    </p>
                    <p class="text-gray-500 leading-relaxed">
                        Dashboard visual menampilkan timeline, persentase penyelesaian, dan notifikasi pembayaran jatuh tempo — sehingga Anda tidak melewatkan satupun deadline.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-black mt-2 group">
                        <span class="border-b-2 border-brand-green group-hover:border-black transition-colors">Coba sekarang</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
                <!-- Character cropped & blended -->
                <div class="w-full md:w-1/2 relative flex justify-center overflow-hidden" style="min-height: 420px;">
                    <div class="absolute inset-0" style="-webkit-mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 60%, transparent 100%);">
                        <img src="{{ asset('backgroud_asset/hero5.png') }}" alt="ArchiBot monitoring proyek" class="w-full h-full object-contain" />
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- HOW IT WORKS --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full bg-gradient-to-b from-gray-50 to-white py-24 md:py-32 px-6 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-20">
                    <span class="text-xs font-mono font-bold text-green-600 uppercase tracking-[0.2em]">Cara Kerja</span>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-black tracking-tight mt-3 mb-4">Tiga langkah menuju invoice sempurna.</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="relative w-full overflow-hidden mb-6" style="height: 260px; -webkit-mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%);">
                            <img src="{{ asset('backgroud_asset/hero1.png') }}" alt="Step 1" class="w-full h-full object-contain group-hover:scale-[1.03] transition-transform duration-500" />
                        </div>
                        <div class="w-10 h-10 bg-brand-green border-2 border-black text-black font-display font-bold flex items-center justify-center text-lg mb-4 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">1</div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">Jelaskan Proyek</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-xs">Ceritakan detail proyek kepada ArchiBot — klien, item pekerjaan, harga, dan deadline.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="relative w-full overflow-hidden mb-6" style="height: 260px; -webkit-mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%);">
                            <img src="{{ asset('backgroud_asset/hero6.png') }}" alt="Step 2" class="w-full h-full object-contain group-hover:scale-[1.03] transition-transform duration-500" />
                        </div>
                        <div class="w-10 h-10 bg-[#FFD6E8] border-2 border-black text-black font-display font-bold flex items-center justify-center text-lg mb-4 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">2</div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">AI Memproses Data</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-xs">ArchiBot mengekstrak data penting dan menyusunnya ke format invoice terstruktur.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center text-center group">
                        <div class="relative w-full overflow-hidden mb-6" style="height: 260px; -webkit-mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%); mask-image: radial-gradient(ellipse 85% 90% at 50% 50%, black 60%, transparent 100%);">
                            <img src="{{ asset('backgroud_asset/hero7.png') }}" alt="Step 3" class="w-full h-full object-contain group-hover:scale-[1.03] transition-transform duration-500" />
                        </div>
                        <div class="w-10 h-10 bg-[#D6E8FF] border-2 border-black text-black font-display font-bold flex items-center justify-center text-lg mb-4 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">3</div>
                        <h3 class="text-lg font-bold text-black mb-2 font-display">Invoice Siap Kirim</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-xs">PDF invoice bergaya blueprint langsung tersedia untuk download atau dikirim ke email klien.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- CTA & TESTIMONIAL MARQUEE (Band.ai Style) --}}
        {{-- ═══════════════════════════════════════════ --}}
        <section class="w-full bg-white text-slate-800 py-24 md:py-32 px-0 relative overflow-hidden border-t border-slate-100">
            <style>
                @keyframes marquee {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .animate-marquee {
                    animation: marquee 30s linear infinite;
                    width: max-content;
                }
                .animate-marquee:hover {
                    animation-play-state: paused;
                }
            </style>

            <div class="max-w-4xl mx-auto text-center flex flex-col items-center gap-4 px-6 mb-16">
                <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-slate-900 font-mono tracking-tighter">scattered agents</h2>
                <p class="text-slate-500 text-[15px] max-w-lg leading-relaxed">
                    Connect everything with ArchiAgent. Bergabung dengan ratusan arsitek yang telah mengotomasi studio mereka.
                </p>
                <a href="{{ route('login') }}" class="mt-4 px-6 py-2.5 bg-[#90ee90] hover:bg-[#7fdf7f] border border-black rounded-xl text-black font-semibold text-[14px] transition-colors flex justify-center items-center shadow-sm">
                    Get in Touch
                </a>
            </div>

            <!-- Marquee Wrapper -->
            <div class="relative flex overflow-hidden w-full group">
                <!-- Fade masks -->
                <div class="absolute inset-0 z-10 pointer-events-none" style="background: linear-gradient(to right, white 0%, transparent 15%, transparent 85%, white 100%);"></div>
                
                <div class="py-4 flex space-x-6 animate-marquee px-6">
                    <!-- Card 1 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-pink-100 flex items-center justify-center font-bold text-pink-600 text-[13px]">AR</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Arief Rahman</h4>
                                <p class="text-slate-500 text-[12px]">@arief/studio</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"ArchiAgent mengubah cara saya bekerja. Saya tidak perlu lagi pusing memikirkan template invoice setiap selesai tender."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Invoice</span>
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Auto-pilot</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-[13px]">BS</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Bima Studio</h4>
                                <p class="text-slate-500 text-[12px]">@bima/architects</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Sangat mudah digunakan! AI-nya mengerti istilah-istilah arsitektur seperti DED, RAB, dan As-Built Drawing dengan sempurna."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">AI Parsing</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-green-100 flex items-center justify-center font-bold text-green-600 text-[13px]">CM</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Citra Mandiri</h4>
                                <p class="text-slate-500 text-[12px]">@citra/design</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Klien saya sangat terkesan dengan invoice yang dikirimkan. Sangat rapi, profesional, dan prosesnya hanya hitungan detik."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Professional</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-purple-100 flex items-center justify-center font-bold text-purple-600 text-[13px]">DD</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Dimas Design</h4>
                                <p class="text-slate-500 text-[12px]">@dimas/interior</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Micro-CRM terbaik untuk arsitek freelance. Saya bisa melacak semua percakapan harga dengan klien dalam satu tempat."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">CRM</span>
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Interior</span>
                        </div>
                    </div>
                    
                    <!-- DUPLICATE FOR INFINITE LOOP -->
                    <!-- Card 1 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-pink-100 flex items-center justify-center font-bold text-pink-600 text-[13px]">AR</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Arief Rahman</h4>
                                <p class="text-slate-500 text-[12px]">@arief/studio</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"ArchiAgent mengubah cara saya bekerja. Saya tidak perlu lagi pusing memikirkan template invoice setiap selesai tender."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Invoice</span>
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Auto-pilot</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-[13px]">BS</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Bima Studio</h4>
                                <p class="text-slate-500 text-[12px]">@bima/architects</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Sangat mudah digunakan! AI-nya mengerti istilah-istilah arsitektur seperti DED, RAB, dan As-Built Drawing dengan sempurna."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">AI Parsing</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-green-100 flex items-center justify-center font-bold text-green-600 text-[13px]">CM</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Citra Mandiri</h4>
                                <p class="text-slate-500 text-[12px]">@citra/design</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Klien saya sangat terkesan dengan invoice yang dikirimkan. Sangat rapi, profesional, dan prosesnya hanya hitungan detik."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Professional</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="inline-flex flex-col bg-white border border-slate-200 rounded-[20px] p-5 w-[340px] shadow-[0_2px_10px_rgba(0,0,0,0.02)] whitespace-normal text-left shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-[10px] bg-purple-100 flex items-center justify-center font-bold text-purple-600 text-[13px]">DD</div>
                            <div>
                                <h4 class="font-semibold text-slate-900 text-[14px]">Dimas Design</h4>
                                <p class="text-slate-500 text-[12px]">@dimas/interior</p>
                            </div>
                        </div>
                        <p class="text-slate-600 text-[13px] leading-relaxed mb-5">"Micro-CRM terbaik untuk arsitek freelance. Saya bisa melacak semua percakapan harga dengan klien dalam satu tempat."</p>
                        <div class="flex gap-2">
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">CRM</span>
                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 text-[11px] border border-slate-100 rounded-md font-medium">Interior</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    
    {{-- ═══════════════════════════════════════════ --}}
    {{-- FOOTER --}}
    {{-- ═══════════════════════════════════════════ --}}
    <footer class="w-full bg-[#f9f9faf0] text-slate-800 border-t border-slate-200/60 mt-10">
        <!-- Main footer -->
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 lg:gap-16">
                
                <!-- Brand column -->
                <div class="md:col-span-1 flex flex-col items-start">
                    <div class="flex items-center gap-3 mb-5">
                        <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="ArchiAgent Logo" class="w-8 h-8 object-contain" />
                        <span class="text-xl font-bold tracking-tight text-slate-900 uppercase">ArchiAgent</span>
                    </div>
                    <p class="text-slate-500 text-[13px] leading-relaxed mb-6 max-w-[220px]">
                        Interaction infrastructure for distributed AI architects.
                    </p>
                    <!-- Social icons (No boxes) -->
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-slate-900 hover:text-slate-600 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="text-slate-900 hover:text-slate-600 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="#" class="text-slate-900 hover:text-slate-600 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Company -->
                <div class="md:col-span-1">
                    <h4 class="font-bold text-[10px] text-slate-800 uppercase tracking-widest mb-6 font-mono">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">About</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Contact</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <!-- Platform -->
                <div class="md:col-span-1">
                    <h4 class="font-bold text-[10px] text-slate-800 uppercase tracking-widest mb-6 font-mono">Platform</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Overview</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Agentic Mesh</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Control Plane</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Integrations</a></li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div class="md:col-span-1">
                    <h4 class="font-bold text-[10px] text-slate-800 uppercase tracking-widest mb-6 font-mono">Solutions</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">For Developers</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">For Engineering Teams</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">For Enterprise Platforms</a></li>
                        <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">For AI Builders</a></li>
                    </ul>
                </div>

                <!-- Resources & Other -->
                <div class="md:col-span-1 flex flex-col gap-10">
                    <div>
                        <h4 class="font-bold text-[10px] text-slate-800 uppercase tracking-widest mb-6 font-mono">Resources</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Ecosystem</a></li>
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Documentation</a></li>
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Blog</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-[10px] text-slate-800 uppercase tracking-widest mb-6 font-mono">Other</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Terms of Service</a></li>
                            <li><a href="#" class="text-[#0e5153] hover:text-slate-900 text-[13px] font-medium transition-colors">Security Issue</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</x-layouts.guest>
