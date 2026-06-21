@props(['activeProjects', 'selectedProjectId', 'editingProjectId'])

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
