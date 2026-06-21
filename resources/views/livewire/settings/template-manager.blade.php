<div class="p-6 md:p-10 max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Visual Template Manager</h1>
        <p class="text-slate-500 text-sm mt-1">Upload your blank invoice design and drag the data fields to their desired positions.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 px-4 py-3 bg-teal-50 border border-teal-200 text-teal-700 rounded-xl text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Settings Panel -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Upload Box -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800 mb-3">1. Upload Base Template</h3>
                <form wire:submit="uploadImage" class="space-y-4">
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:bg-slate-50 transition-colors">
                        <input type="file" wire:model="image" id="template_image" class="hidden" accept="image/*">
                        <label for="template_image" class="cursor-pointer flex flex-col items-center gap-2">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span class="text-xs text-slate-500 font-medium">Click to select image</span>
                        </label>
                    </div>
                    @error('image') <span class="text-[10px] text-red-500 font-medium">{{ $message }}</span> @enderror
                    
                    <button type="submit" wire:loading.attr="disabled" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm disabled:opacity-50">
                        Upload & Apply
                    </button>
                </form>
            </div>

            <!-- Mapping Info -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-800 mb-2">2. Map Data Fields</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                    Drag the floating data fields on the canvas to place them exactly where you want them to appear on your PDF invoice.
                </p>
                <button wire:click="saveMapping" class="w-full py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                    Save Field Positions
                </button>
            </div>
        </div>

        <!-- Canvas Area -->
        <div class="lg:col-span-3">
            <div class="bg-slate-100 border border-slate-200 rounded-2xl p-4 md:p-8 flex items-center justify-center min-h-[600px] overflow-hidden">
                @if($template && $template->background_path)
                    <!-- Alpine.js Draggable Canvas -->
                    <div 
                        class="relative bg-white shadow-xl max-w-full outline-none focus:outline-none"
                        tabindex="0"
                        style="width: 800px; aspect-ratio: 1 / 1.414; /* A4 Ratio */"
                        x-data="{
                            fields: @entangle('fields'),
                            dragging: null,
                            selectedField: null,
                            startDrag(event, key) {
                                this.dragging = key;
                                this.selectedField = key;
                            },
                            onDrag(event) {
                                if (!this.dragging) return;
                                const rect = this.$refs.canvas.getBoundingClientRect();
                                let x = ((event.clientX - rect.left) / rect.width) * 100;
                                let y = ((event.clientY - rect.top) / rect.height) * 100;
                                
                                // constrain
                                x = Math.max(0, Math.min(100, x));
                                y = Math.max(0, Math.min(100, y));

                                this.fields[this.dragging].x = x;
                                this.fields[this.dragging].y = y;
                            },
                            stopDrag() {
                                if (this.dragging) {
                                    $wire.updateFieldPosition(this.dragging, this.fields[this.dragging].x, this.fields[this.dragging].y);
                                    this.dragging = null;
                                }
                            },
                            handleKeydown(event) {
                                if (!this.selectedField) return;
                                const step = event.shiftKey ? 1 : 0.1; // Shift for larger jump
                                let changed = false;
                                
                                if (event.key === 'ArrowUp') { this.fields[this.selectedField].y = Math.max(0, this.fields[this.selectedField].y - step); changed = true; }
                                else if (event.key === 'ArrowDown') { this.fields[this.selectedField].y = Math.min(100, this.fields[this.selectedField].y + step); changed = true; }
                                else if (event.key === 'ArrowLeft') { this.fields[this.selectedField].x = Math.max(0, this.fields[this.selectedField].x - step); changed = true; }
                                else if (event.key === 'ArrowRight') { this.fields[this.selectedField].x = Math.min(100, this.fields[this.selectedField].x + step); changed = true; }
                                
                                if (changed) {
                                    event.preventDefault();
                                    $wire.updateFieldPosition(this.selectedField, this.fields[this.selectedField].x, this.fields[this.selectedField].y);
                                }
                            }
                        }"
                        x-ref="canvas"
                        @mousemove.window="onDrag($event)"
                        @mouseup.window="stopDrag()"
                        @keydown.window="handleKeydown($event)"
                        @click.away="selectedField = null"
                    >
                        <!-- Background Image -->
                        <img src="{{ Storage::url($template->background_path) }}" class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-90" alt="Invoice Template">
                        
                        <!-- Overlay Fields -->
                        <template x-for="(data, key) in fields" :key="key">
                            <div 
                                class="absolute cursor-move select-none px-2 py-1 border-2 border-dashed border-teal-500 bg-white/80 backdrop-blur-sm rounded shadow-sm text-xs font-semibold whitespace-nowrap transition-shadow hover:shadow-md"
                                :class="dragging === key ? 'ring-2 ring-teal-400 z-50' : (selectedField === key ? 'ring-2 ring-orange-400 z-40' : 'z-10')"
                                :style="`left: ${data.x}%; top: ${data.y}%; color: ${data.color}; font-size: ${data.font_size}px; transform: translate(-50%, -50%);`"
                                @mousedown.prevent="startDrag($event, key)"
                            >
                                <span class="bg-teal-500 text-white text-[9px] px-1 rounded-sm absolute -top-4 left-0 uppercase tracking-widest font-mono" x-text="data.label"></span>
                                [ <span x-text="data.label"></span> ]
                            </div>
                        </template>
                    </div>
                @else
                    <div class="text-center">
                        <div class="w-16 h-16 bg-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-700">No Template Found</h3>
                        <p class="text-xs text-slate-500 mt-1">Upload an image on the left panel to begin mapping.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
