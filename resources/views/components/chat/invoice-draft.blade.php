@props(['draftData', 'isEditingDraft'])

<div class="mb-4 animate-slide-up max-w-3xl mx-auto">
    <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-lg shadow-slate-200/50">
        <!-- Card Header -->
        <div class="bg-teal-50/50 border-b border-slate-100 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2 text-teal-700">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                <h3 class="text-[10px] font-bold font-mono uppercase tracking-widest">Human-in-the-loop &middot; Awaiting Confirmation</h3>
            </div>
            <span class="text-[10px] font-mono text-slate-400">action: generate_invoice</span>
        </div>

        <!-- Card Body -->
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Client Name</p>
                    @if($isEditingDraft)
                        <input type="text" wire:model="draftData.client_name" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono focus:ring-1 focus:ring-teal-500 outline-none">
                    @else
                        <p class="text-sm text-slate-800 font-mono">{{ $draftData['client_name'] ?? '-' }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Project Name</p>
                    @if($isEditingDraft)
                        <input type="text" wire:model="draftData.project_name" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono focus:ring-1 focus:ring-teal-500 outline-none">
                    @else
                        <p class="text-sm text-slate-800 font-mono">{{ $draftData['project_name'] ?? '-' }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Invoice Number</p>
                    @if($isEditingDraft)
                        <input type="text" wire:model="draftData.invoice_number" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono focus:ring-1 focus:ring-teal-500 outline-none">
                    @else
                        <p class="text-sm text-slate-800 font-mono">{{ $draftData['invoice_number'] ?? '-' }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Termin Name</p>
                    @if($isEditingDraft)
                        <input type="text" wire:model="draftData.termin_name" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono focus:ring-1 focus:ring-teal-500 outline-none">
                    @else
                        <p class="text-sm text-slate-800 font-mono">{{ $draftData['termin_name'] ?? '-' }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Percentage</p>
                    @if($isEditingDraft)
                        <div class="flex items-center gap-2">
                            <input type="number" wire:model="draftData.percentage" class="w-20 bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono focus:ring-1 focus:ring-teal-500 outline-none">
                            <span class="text-sm text-slate-800 font-mono">%</span>
                        </div>
                    @else
                        <p class="text-sm text-slate-800 font-mono">{{ $draftData['percentage'] ?? 0 }} %</p>
                    @endif
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-mono text-slate-400 mb-1">Total Amount</p>
                    @if($isEditingDraft)
                        <div class="flex items-center gap-2" x-data="{ 
                            formatted: new Intl.NumberFormat('id-ID').format($wire.get('draftData.amount') || 0)
                        }">
                            <span class="text-sm text-slate-800 font-mono font-semibold">Rp</span>
                            <input type="text" x-model="formatted" 
                                @input="
                                    let val = $event.target.value.replace(/\D/g, '');
                                    $wire.set('draftData.amount', val ? parseInt(val, 10) : 0);
                                    formatted = val ? new Intl.NumberFormat('id-ID').format(val) : '';
                                "
                                class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 text-sm text-slate-800 font-mono font-semibold focus:ring-1 focus:ring-teal-500 outline-none">
                        </div>
                    @else
                        <p class="text-sm text-teal-700 font-mono font-semibold">Rp {{ number_format($draftData['amount'] ?? 0, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="border-t border-slate-100 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
            <p class="text-xs text-slate-400 font-mono hidden sm:block">Verify before sending to client &rarr;</p>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button wire:click="cancelProcess" wire:loading.attr="disabled" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 text-[11px] font-bold font-mono tracking-widest rounded-xl transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    CANCEL
                </button>
                
                @if($isEditingDraft)
                    <button wire:click="toggleEditDraft" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] font-bold font-mono tracking-widest rounded-xl transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        DONE EDITING
                    </button>
                @else
                    <button wire:click="toggleEditDraft" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 text-[11px] font-bold font-mono tracking-widest rounded-xl transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        EDIT
                    </button>
                    <button wire:click="confirmAndSave" wire:loading.attr="disabled" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-5 py-2.5 bg-black hover:bg-slate-800 text-white text-[11px] font-bold font-mono tracking-widest rounded-xl transition-colors shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span wire:loading.remove wire:target="confirmAndSave">YES, PROCESS</span>
                        <span wire:loading wire:target="confirmAndSave">PROCESSING...</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
