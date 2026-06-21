<div class="flex h-screen overflow-hidden bg-white"
    x-data="{ mobileMenuOpen: false, pdfModalOpen: false, pdfUrl: '' }"
    x-init="$nextTick(() => $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight)"
    @scroll-to-bottom.window="$nextTick(() => $refs.chatContainer.scrollTo({ top: $refs.chatContainer.scrollHeight, behavior: 'smooth' }))"
>
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 md:hidden" 
         x-transition.opacity @click="mobileMenuOpen = false" style="display: none;"></div>

    <!-- Sidebar -->
    <x-chat.sidebar 
        :active-projects="$activeProjects" 
        :selected-project-id="$selectedProjectId" 
        :editing-project-id="$editingProjectId" 
    />

    <!-- Main Content (Chat Workspace) -->
    <main class="flex-1 flex flex-col relative z-10 w-full">
        <!-- Header -->
        <header class="flex-shrink-0 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white/80 backdrop-blur-md sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button @click="mobileMenuOpen = true" class="md:hidden flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-slate-700">Project Context:</span>
                    </div>
            </div>

            <!-- Context Chips -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
                @if($activeProject)
                    <div class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-200/80 bg-white/60 text-[9px] font-bold text-slate-500 font-mono uppercase tracking-widest shadow-sm">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        CLIENT: {{ $activeProject->client->client_name ?? 'UNKNOWN' }}
                    </div>
                    <div class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-200/80 bg-white/60 text-[9px] font-bold text-slate-500 font-mono uppercase tracking-widest shadow-sm">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        {{ $activeProject->project_name }}
                    </div>
                    <div class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-teal-200 bg-teal-50/80 text-[9px] font-bold text-teal-700 font-mono uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        STATUS: {{ $activeProject->status ?? 'ACTIVE' }}
                    </div>
                @else
                    <div class="flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-100 bg-slate-50 text-[10px] font-medium text-slate-500 tracking-wide">
                        NO PROJECT SELECTED
                    </div>
                @endif
                <button class="hidden md:flex ml-2 flex-shrink-0 items-center justify-center w-8 h-8 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                </button>
            </div>
        </header>

        <!-- Chat Area -->
        <div class="flex-1 overflow-y-auto chat-scroll px-4 sm:px-10 py-6 space-y-6 relative" x-ref="chatContainer">
            @if(empty($chatLogs))
                <!-- Empty State (Bud.app style) -->
                <div class="flex flex-col items-center justify-start mt-6 min-h-[70vh] max-w-2xl mx-auto px-4 w-full">
                    <!-- Top Logo -->
                    <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="ArchiAgent" class="w-32 h-32 object-contain mb-4 drop-shadow-sm" />
                    
                    <!-- Time and Location -->
                    <div class="flex items-center gap-1.5 text-[12px] text-slate-500 mb-2 font-medium">
                        <span>{{ now()->format('g:i A') }}</span>
                        <span>-</span>
                        <span>Yogyakarta 25&deg;</span>
                        <svg class="w-3.5 h-3.5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    </div>
                    
                    <!-- Main Title -->
                    <h2 class="text-[26px] font-bold text-slate-900 mb-3 tracking-tight">ArchiAgent</h2>
                    
                    <!-- Subtitle -->
                    <p class="text-slate-500 text-[13px] mb-8 leading-relaxed max-w-sm text-center">
                        Asisten cerdas untuk arsitek freelance Indonesia.<br/>Ekstrak RAB, buat draft invoice, dan pantau proyek otomatis.
                    </p>

                    <!-- Quick Actions Container -->
                    <div class="bg-white border border-slate-100 rounded-[28px] p-2 flex flex-col items-center gap-2 mb-10 shadow-[0_2px_8px_rgba(0,0,0,0.02)] w-full max-w-[440px]">
                        <!-- Row 1 -->
                        <div class="flex items-center justify-center gap-2 w-full">
                            <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#f9f9fa] hover:bg-slate-50 rounded-full text-[13px] font-medium text-slate-700 transition-colors">
                                <span class="w-4 h-4 rounded-full bg-green-500 flex items-center justify-center text-white text-[8px]"><svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></span>
                                Upload PDF RAB
                            </button>
                            <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#f9f9fa] hover:bg-slate-50 rounded-full text-[13px] font-medium text-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.18-.08-.05-.19-.02-.27 0l-3.8 2.4c-.54.38-1.04.56-1.53.55-.54-.01-1.56-.3-2.33-.56-.93-.31-1.67-.48-1.61-.99.03-.26.39-.53 1.09-.81 4.27-1.86 7.12-3.08 8.55-3.68 4.07-1.7 4.92-2 5.48-2 .12 0 .4.03.55.15.12.1.16.24.18.36.01.12.02.26.01.4z"/></svg>
                                Buat Draft Invoice
                            </button>
                        </div>
                        <!-- Row 2 -->
                        <div class="flex items-center justify-center gap-2 w-full">
                            <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#f9f9fa] hover:bg-slate-50 rounded-full text-[13px] font-medium text-slate-600 transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Data Klien
                            </button>
                            <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#f9f9fa] hover:bg-slate-50 rounded-full text-[13px] font-medium text-slate-600 transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Proyek Aktif
                            </button>
                            <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#f9f9fa] hover:bg-slate-50 rounded-full text-[13px] font-medium text-slate-600 transition-colors">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Rekap Keuangan
                            </button>
                        </div>
                    </div>

                    <!-- Watch Replays / Recent Projects -->
                    <div class="w-full max-w-[440px] text-left">
                        <h3 class="text-[12px] text-slate-400 font-medium mb-3 px-2">Contoh Instruksi Cepat</h3>
                        <div class="flex flex-col gap-0.5">
                            @forelse(collect($activeProjects)->take(4) as $proj)
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Buat draft invoice untuk {{ $proj->project_name }}</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            @empty
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Ekstrak data klien dari PDF RAB Bapak Damar</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Buatkan penawaran harga untuk desain interior Rumah Minimalis</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Kirim pengingat tagihan termin ke-2 untuk Proyek Cafe Starbuck</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Rekap total invoice lunas bulan ini ke format Excel</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="flex items-center justify-between px-3 py-2.5 hover:bg-slate-50 rounded-xl transition-colors group w-full text-left">
                                <div class="flex items-center gap-3">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/></svg>
                                    <span class="text-[13px] text-slate-600 truncate max-w-[300px]">Tampilkan semua klien yang tagihannya masih Pending</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <!-- Date Separator -->
                <div class="flex justify-center mb-6">
                    <span class="px-3 py-1 rounded-md bg-transparent text-xs font-medium text-slate-400">
                        Today &middot; {{ now()->format('H:i') }}
                    </span>
                </div>
            @endif

            @foreach($chatLogs as $index => $log)
                <x-chat.message-bubble :log="$log" :index="$index" />
            @endforeach

            <!-- Loading Indicator -->
            <div wire:loading wire:target="sendMessage" class="flex justify-start animate-fade-in-up">
                <div class="flex-shrink-0 mr-4 mt-1 hidden sm:block">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm border border-slate-100 overflow-hidden">
                        <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="AI" class="w-8 h-8 object-contain" />
                    </div>
                </div>
                <div class="flex flex-col items-start">
                    <span class="text-[10px] font-bold font-mono text-slate-400 tracking-widest mb-1.5 ml-1">ARCHIAGENT</span>
                    <div class="bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl rounded-tl-sm px-5 py-4 shadow-sm">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-1">
                                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
                                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
                                <div class="w-1.5 h-1.5 bg-slate-400 rounded-full typing-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Area -->
        <footer class="flex-shrink-0 px-4 sm:px-10 pb-8 pt-4 bg-gradient-to-t from-white via-white to-transparent">
            <!-- Confirmation Card -->
            @if($showConfirmationCard && !empty($draftData))
                <x-chat.invoice-draft :draftData="$draftData" :isEditingDraft="$isEditingDraft" />
            @endif

            <!-- Input Box -->
            <x-chat.input-area :pdfFile="$pdfFile" :message="$message" />
        </footer>
    </main>

    <!-- PDF Preview Modal -->
    <div x-show="pdfModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4 sm:p-6" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl h-full max-h-[90vh] flex flex-col overflow-hidden" @click.away="pdfModalOpen = false">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800">Invoice Preview</h3>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="pdfUrl" target="_blank" download class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download PDF
                    </a>
                    <button @click="pdfModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors p-2 rounded-lg hover:bg-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="flex-1 bg-slate-200 p-2 sm:p-6 overflow-hidden relative">
                <!-- iframe object for PDF -->
                <iframe :src="pdfUrl + '#toolbar=0&navpanes=0&scrollbar=0'" class="w-full h-full rounded shadow-sm bg-white" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
