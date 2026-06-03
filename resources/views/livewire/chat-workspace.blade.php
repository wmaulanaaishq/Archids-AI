<div
    class="flex flex-col h-screen max-h-screen bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950"
    x-data="{ }"
    x-init="$nextTick(() => $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight)"
    @scroll-to-bottom.window="$nextTick(() => $refs.chatContainer.scrollTo({ top: $refs.chatContainer.scrollHeight, behavior: 'smooth' }))"
>
    {{-- ============================================= --}}
    {{-- HEADER --}}
    {{-- ============================================= --}}
    <header class="flex-shrink-0 border-b border-slate-800/60 glass bg-slate-900/70">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3 flex items-center gap-3">
            {{-- Logo Icon --}}
            <div class="relative">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-studio-500 to-studio-700 flex items-center justify-center shadow-lg shadow-studio-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-slate-900"></div>
            </div>

            <div>
                <h1 class="text-base font-semibold text-white tracking-tight">ArchiAgent</h1>
                <p class="text-xs text-slate-400 font-medium">AI Invoice Assistant · Online</p>
            </div>

            {{-- Right side: Model badge --}}
            <div class="ml-auto">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-mono font-medium bg-studio-500/10 text-studio-300 border border-studio-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-studio-400 animate-pulse"></span>
                    DeepSeek V4
                </span>
            </div>
        </div>
    </header>

    {{-- ============================================= --}}
    {{-- CHAT AREA --}}
    {{-- ============================================= --}}
    <main class="flex-1 overflow-y-auto chat-scroll" x-ref="chatContainer">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 space-y-4">
            @foreach($chatLogs as $index => $log)
                <div
                    class="flex animate-fade-in-up {{ $log['role'] === 'user' ? 'justify-end' : 'justify-start' }}"
                    wire:key="chat-{{ $index }}"
                >
                    @if($log['role'] === 'assistant')
                        {{-- AI Avatar --}}
                        <div class="flex-shrink-0 mr-3 mt-1">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-studio-500 to-studio-700 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                                </svg>
                            </div>
                        </div>
                    @endif

                    {{-- Chat Bubble --}}
                    <div class="max-w-[80%] sm:max-w-[70%]">
                        <div class="rounded-2xl px-4 py-3 text-sm leading-relaxed
                            {{ $log['role'] === 'user'
                                ? 'bg-studio-500 text-white rounded-br-md shadow-lg shadow-studio-500/10'
                                : 'bg-slate-800/80 text-slate-200 rounded-bl-md border border-slate-700/50'
                            }}">
                            <div class="chat-prose">
                                {!! \Illuminate\Support\Str::markdown($log['content']) !!}
                            </div>
                        </div>

                        {{-- Download Button (jika ada download_url) --}}
                        @if(!empty($log['download_url']))
                            <a
                                href="{{ $log['download_url'] }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 mt-2 px-4 py-2.5 bg-gradient-to-r from-studio-500 to-studio-600 hover:from-studio-400 hover:to-studio-500 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-lg shadow-studio-500/20 hover:shadow-studio-500/30 hover:-translate-y-0.5 group"
                            >
                                <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Unduh Invoice PDF
                            </a>
                        @endif

                        {{-- Timestamp --}}
                        <p class="text-[10px] mt-1.5 {{ $log['role'] === 'user' ? 'text-right' : 'text-left' }} text-slate-500 font-mono">
                            {{ now()->format('H:i') }}
                        </p>
                    </div>

                    @if($log['role'] === 'user')
                        {{-- User Avatar --}}
                        <div class="flex-shrink-0 ml-3 mt-1">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- Loading Indicator --}}
            <div wire:loading wire:target="sendMessage" class="flex justify-start animate-fade-in-up">
                <div class="flex-shrink-0 mr-3 mt-1">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-studio-500 to-studio-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>
                        </svg>
                    </div>
                </div>
                <div class="bg-slate-800/80 border border-slate-700/50 rounded-2xl rounded-bl-md px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-studio-400 rounded-full typing-dot"></div>
                            <div class="w-2 h-2 bg-studio-400 rounded-full typing-dot"></div>
                            <div class="w-2 h-2 bg-studio-400 rounded-full typing-dot"></div>
                        </div>
                        <span class="text-sm text-slate-400 font-medium">ArchiAgent sedang memproses...</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ============================================= --}}
    {{-- BOTTOM AREA (Confirmation Card + Input) --}}
    {{-- ============================================= --}}
    <footer class="flex-shrink-0 border-t border-slate-800/60 glass bg-slate-900/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            {{-- ========== CONFIRMATION CARD ========== --}}
            @if($showConfirmationCard && !empty($draftData))
                <div class="py-4 animate-slide-up">
                    <div class="bg-gradient-to-br from-slate-800 to-slate-800/60 border border-slate-700/60 rounded-2xl overflow-hidden shadow-2xl shadow-black/20">
                        {{-- Card Header --}}
                        <div class="bg-gradient-to-r from-studio-500/15 to-studio-700/10 border-b border-slate-700/40 px-5 py-3 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-studio-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-studio-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Konfirmasi Draft Invoice</h3>
                                <p class="text-[11px] text-slate-400">Periksa data berikut sebelum disimpan</p>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="px-5 py-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {{-- Client Name --}}
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-violet-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Klien</p>
                                        <p class="text-sm text-white font-medium">{{ $draftData['client_name'] ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Project Name --}}
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-blue-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Proyek</p>
                                        <p class="text-sm text-white font-medium">{{ $draftData['project_name'] ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Invoice Number --}}
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-amber-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">No. Invoice</p>
                                        <p class="text-sm text-white font-mono font-medium">{{ $draftData['invoice_number'] ?? '-' }}</p>
                                    </div>
                                </div>

                                {{-- Termin --}}
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-md bg-emerald-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Termin</p>
                                        <p class="text-sm text-white font-medium">{{ $draftData['termin_name'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Percentage + Amount (Highlighted) --}}
                            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                <div class="flex-1 bg-studio-500/8 border border-studio-500/15 rounded-xl px-4 py-3 text-center">
                                    <p class="text-[10px] uppercase tracking-wider text-studio-300/70 font-semibold">Persentase</p>
                                    <p class="text-2xl font-bold text-studio-300 font-mono mt-0.5">{{ $draftData['percentage'] ?? 0 }}<span class="text-base text-studio-400/60">%</span></p>
                                </div>
                                <div class="flex-[2] bg-studio-500/8 border border-studio-500/15 rounded-xl px-4 py-3 text-center">
                                    <p class="text-[10px] uppercase tracking-wider text-studio-300/70 font-semibold">Total Nominal</p>
                                    <p class="text-2xl font-bold text-white font-mono mt-0.5">
                                        <span class="text-base text-slate-400">Rp</span>
                                        {{ number_format($draftData['amount'] ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Actions --}}
                        <div class="border-t border-slate-700/40 px-5 py-3 flex items-center gap-3">
                            <button
                                wire:click="confirmAndSave"
                                wire:loading.attr="disabled"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-studio-500 to-emerald-600 hover:from-studio-400 hover:to-emerald-500 disabled:opacity-50 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-studio-500/20 hover:shadow-studio-500/30"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span wire:loading.remove wire:target="confirmAndSave">YA, PROSES</span>
                                <span wire:loading wire:target="confirmAndSave">Menyimpan...</span>
                            </button>
                            <button
                                wire:click="cancelProcess"
                                wire:loading.attr="disabled"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-700/60 hover:bg-red-500/20 hover:border-red-500/30 border border-slate-600/50 text-slate-300 hover:text-red-300 text-sm font-semibold rounded-xl transition-all duration-200"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                BATAL
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ========== INPUT AREA ========== --}}
            <div class="py-3">
                <form wire:submit="sendMessage" class="flex items-end gap-2.5">
                    <div class="flex-1 relative">
                        <textarea
                            wire:model="message"
                            id="chat-input"
                            rows="1"
                            placeholder="Ketik pesan Anda di sini..."
                            class="w-full resize-none rounded-xl border border-slate-700/60 bg-slate-800/60 text-white placeholder-slate-500 px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-studio-500/40 focus:border-studio-500/60 transition-all duration-200"
                            style="max-height: 120px;"
                            x-data
                            x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                            x-on:keydown.enter.prevent="if (!$event.shiftKey) { $wire.sendMessage() }"
                            wire:loading.attr="disabled"
                            wire:target="sendMessage"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                        class="flex-shrink-0 w-11 h-11 rounded-xl bg-gradient-to-r from-studio-500 to-studio-600 hover:from-studio-400 hover:to-studio-500 disabled:opacity-40 disabled:cursor-not-allowed text-white flex items-center justify-center transition-all duration-200 shadow-lg shadow-studio-500/20 hover:shadow-studio-500/30 hover:-translate-y-0.5"
                    >
                        <span wire:loading.remove wire:target="sendMessage">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                            </svg>
                        </span>
                        <span wire:loading wire:target="sendMessage">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </span>
                    </button>
                </form>

                {{-- Footer branding --}}
                <p class="text-center text-[10px] text-slate-600 mt-2 font-medium">
                    ArchiAgent v1.0 · Powered by DeepSeek V4 via Featherless.ai
                </p>
            </div>
        </div>
    </footer>
</div>
