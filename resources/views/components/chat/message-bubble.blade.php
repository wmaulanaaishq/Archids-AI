@props(['log', 'index'])

<div class="flex animate-fade-in-up {{ $log['role'] === 'user' ? 'justify-end' : 'justify-start' }}" wire:key="chat-{{ $index }}">
    @if($log['role'] === 'assistant')
        <!-- AI Avatar Left -->
        <div class="flex-shrink-0 mr-4 mt-1 hidden sm:block">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm border border-slate-100 overflow-hidden">
                <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="AI" class="w-8 h-8 object-contain" />
            </div>
        </div>
    @endif

    <div class="max-w-[90%] sm:max-w-[75%] flex flex-col {{ $log['role'] === 'user' ? 'items-end' : 'items-start' }}">
        <!-- Sender Name -->
        <span class="text-xs font-medium text-slate-400 mb-1 ml-1 {{ $log['role'] === 'user' ? 'mr-1' : '' }}">
            {{ $log['role'] === 'user' ? 'You' : 'ArchiAgent' }}
        </span>

        <!-- Bubble -->
        <div class="px-5 py-3 text-[15px] leading-relaxed
            {{ $log['role'] === 'user'
                ? 'bg-slate-100 text-slate-800 rounded-2xl rounded-tr-sm user-chat'
                : 'bg-transparent text-slate-800 rounded-2xl rounded-tl-sm'
            }}">
            <div class="chat-prose">
                {!! \Illuminate\Support\Str::markdown($log['content']) !!}
            </div>
        </div>

        <!-- Download Button -->
        @if(!empty($log['download_url']))
            <button @click="pdfUrl = '{{ $log['download_url'] }}'; pdfModalOpen = true" class="inline-flex items-center gap-2 mt-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-all duration-200 shadow-sm group">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Invoice PDF
            </button>
        @endif
    </div>
</div>
