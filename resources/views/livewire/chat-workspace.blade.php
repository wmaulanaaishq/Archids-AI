<div class="flex h-screen overflow-hidden bg-white"
    x-data="{ mobileMenuOpen: false, pdfModalOpen: false, pdfUrl: '' }"
    x-init="$nextTick(() => $refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight)"
    @scroll-to-bottom.window="$nextTick(() => $refs.chatContainer.scrollTo({ top: $refs.chatContainer.scrollHeight, behavior: 'smooth' }))"
>
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="mobileMenuOpen" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 md:hidden" 
         x-transition.opacity @click="mobileMenuOpen = false" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="w-72 md:w-80 border-r border-slate-100 flex flex-col flex-shrink-0 absolute md:relative z-40 h-full shadow-2xl md:shadow-none md:translate-x-0 transition-transform duration-300 bg-[#f9f9f9]">
        <!-- Logo -->
        <div class="p-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="ArchiAgent" class="w-12 h-12 object-contain" />
                <h1 class="font-semibold text-slate-800 text-lg tracking-tight">ArchiAgent</h1>
            </div>
        </div>

        <!-- New Chat Button & Search -->
        <div class="px-4 pb-4">
            <button wire:click="startNewChat" class="w-full flex items-center gap-3 px-3 py-2 text-slate-600 font-medium rounded-lg hover:bg-slate-200/50 transition-colors mb-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="text-sm">New chat</span>
            </button>

            <button class="w-full flex items-center gap-3 px-3 py-2 text-slate-600 font-medium rounded-lg hover:bg-slate-200/50 transition-colors mb-4">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span class="text-sm">Chats</span>
            </button>

            <div class="relative mt-4">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="searchProject" type="text" placeholder="Search projects..." class="w-full pl-9 pr-4 py-2 bg-transparent border border-slate-200 rounded-lg text-sm focus:ring-1 focus:ring-slate-300 focus:outline-none transition-all text-slate-600 placeholder-slate-400">
            </div>
        </div>

        <!-- Projects List -->
        <div class="px-4 pt-2 pb-2 flex items-center justify-between mt-2">
            <h2 class="text-[11px] font-medium text-slate-400 tracking-wider">Active Projects</h2>
            <span class="text-[11px] text-slate-400">{{ count($activeProjects) }}</span>
        </div>
        <div class="flex-1 overflow-y-auto chat-scroll px-4 pb-4">
            @forelse($activeProjects as $project)
                <div class="group relative p-3 rounded-xl cursor-pointer transition-colors {{ $selectedProjectId === $project->id ? 'bg-white shadow-sm border border-slate-200/60' : 'hover:bg-slate-100/50 border border-transparent' }} mb-1">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $selectedProjectId === $project->id ? 'text-teal-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        
                        @if($editingProjectId === $project->id)
                            <div class="flex-1 flex items-center gap-1">
                                <input type="text" wire:model="editingProjectName" wire:keydown.enter="saveProjectName" wire:keydown.escape="cancelEditProject" class="w-full bg-white border border-teal-500 rounded px-1.5 py-0.5 text-sm text-slate-800 focus:outline-none" autofocus placeholder="Nama Proyek...">
                                <button wire:click.stop="saveProjectName" class="text-teal-600 hover:text-teal-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                        @else
                            <h3 wire:click="selectProject({{ $project->id }})" @click="mobileMenuOpen = false" class="flex-1 text-sm font-semibold {{ $selectedProjectId === $project->id ? 'text-slate-800' : 'text-slate-600' }} truncate">{{ $project->project_name }}</h3>
                            
                            <!-- Hover Actions -->
                            <div class="absolute right-2 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 flex items-center gap-0.5 transition-opacity bg-white/90 backdrop-blur-md px-1 py-1 rounded-lg border border-slate-100 shadow-sm">
                                <button wire:click.stop="startEditProject({{ $project->id }}, '{{ addslashes($project->project_name) }}')" class="p-1.5 text-slate-400 hover:text-teal-600 transition-colors rounded-md hover:bg-teal-50" title="Edit Name">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button onclick="confirm('Apakah Anda yakin ingin menghapus proyek ini beserta riwayat chatnya?') || event.stopImmediatePropagation()" wire:click.stop="deleteProject({{ $project->id }})" class="p-1.5 text-slate-400 hover:text-red-500 transition-colors rounded-md hover:bg-red-50" title="Delete Project">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>

                            @if($selectedProjectId === $project->id)
                                <div class="ml-auto w-1.5 h-1.5 rounded-full bg-teal-500 flex-shrink-0 group-hover:opacity-0 transition-opacity"></div>
                            @endif
                        @endif
                    </div>
                    @if($editingProjectId !== $project->id)
                        <p wire:click="selectProject({{ $project->id }})" @click="mobileMenuOpen = false" class="text-xs {{ $selectedProjectId === $project->id ? 'text-slate-500' : 'text-slate-400' }} mt-1 pl-6 truncate">{{ $project->client->client_name ?? 'Unknown Client' }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-6 text-slate-400 text-xs">
                    No active projects found.
                </div>
            @endforelse
        </div>

        <!-- User Profile -->
        <div class="p-4 bg-white m-4 rounded-2xl border border-slate-100 shadow-sm mt-auto">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <h4 class="text-sm font-medium text-slate-800">{{ Auth::user()->name ?? 'Wahyu Maulana' }}</h4>
                    <p class="text-xs text-slate-500 truncate">Learn what Archi can do</p>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('settings.template') }}" class="text-slate-400 hover:text-teal-600 transition-colors p-1" title="Invoice Settings">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </a>
                    <button wire:click="logout" class="text-slate-400 hover:text-red-500 transition-colors p-1" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </aside>

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
            @endif

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
