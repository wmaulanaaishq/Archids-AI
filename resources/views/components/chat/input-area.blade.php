@props(['pdfFile', 'message'])

<!-- Input Box (Floating Pill) -->
<div class="max-w-3xl mx-auto relative">
    <form wire:submit="sendMessage" class="relative group w-full">
        
        @if($pdfFile)
        <div class="mb-3 flex items-center gap-2 bg-indigo-50 border border-indigo-100 px-3 py-2 rounded-xl text-sm text-indigo-700 max-w-sm ml-2">
            <svg class="w-4 h-4 text-indigo-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
            <span class="truncate font-medium">Menganalisis PDF...</span>
        </div>
        @endif

        <div class="relative flex items-end w-full">
            <label for="pdf-upload" class="absolute left-3 bottom-2 flex items-center justify-center w-10 h-10 rounded-full hover:bg-slate-100 text-slate-400 cursor-pointer transition-colors z-10" title="Upload PDF">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
            </label>
            <input id="pdf-upload" type="file" wire:model="pdfFile" accept=".pdf" class="hidden" />

            <textarea
                wire:model="message"
                rows="1"
                placeholder="Tanya apapun atau lampirkan PDF..."
                class="w-full resize-none rounded-[24px] border border-slate-200 bg-white shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] text-slate-800 text-[15px] placeholder-slate-400 py-4 pl-14 pr-14 focus:outline-none focus:ring-1 focus:ring-slate-300 transition-all"
                style="max-height: 200px; line-height: 1.5;"
                x-data
                x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                x-on:keydown.enter.prevent="if (!$event.shiftKey) { $wire.sendMessage() }"
                wire:loading.attr="disabled"
                wire:target="sendMessage, pdfFile"
            ></textarea>

            <div class="absolute right-3 bottom-2 flex items-center">
                <button type="submit" wire:loading.attr="disabled" wire:target="sendMessage, pdfFile" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 disabled:opacity-50 text-slate-600 flex items-center justify-center transition-colors">
                    <span wire:loading.remove wire:target="sendMessage">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </span>
                    <span wire:loading wire:target="sendMessage">
                        <svg class="w-4 h-4 animate-spin text-slate-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </span>
                </button>
            </div>
        </div>
    </form>

    <p class="text-center text-[9px] font-mono tracking-widest text-slate-400 mt-3">
        ArchiAgent may produce inaccurate billing &mdash; always review before sending.
    </p>
</div>
