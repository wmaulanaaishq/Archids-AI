<div class="min-h-screen flex items-center justify-center p-6 bg-[#f4f4f5] relative z-20">
    <div class="w-full max-w-[420px]">
        <!-- Clean Card -->
        <div class="bg-white rounded-[24px] p-8 sm:p-10 shadow-sm border border-slate-100">
            
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('backgroud_asset/logo_archidsai.png') }}" alt="ArchiAgent" class="w-12 h-12 object-contain" />
                    <span class="font-bold text-xl tracking-tight text-slate-800 uppercase">ARCHIAGENT</span>
                </div>
            </div>

            <h2 class="text-[20px] font-semibold text-slate-800 mb-5 tracking-tight">Login</h2>
            
            <form wire:submit="login" class="space-y-4">
                <!-- Email -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-[13px] font-medium text-slate-700">Email</label>
                    <input wire:model="email" type="email" id="email" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-[14px] text-slate-800 shadow-[0_1px_2px_rgba(0,0,0,0.02)]" required autofocus>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5 relative">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-[13px] font-medium text-slate-700">Password</label>
                        <a href="#" class="text-[12px] text-slate-500 hover:text-slate-800 transition-colors">Forgot your password?</a>
                    </div>
                    <input wire:model="password" type="password" id="password" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-[14px] text-slate-800 shadow-[0_1px_2px_rgba(0,0,0,0.02)]" required>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center pt-2 pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <div class="relative flex items-center">
                            <input wire:model="remember" type="checkbox" class="peer appearance-none w-[18px] h-[18px] border border-slate-300 rounded-md bg-white checked:bg-black checked:border-black transition-colors cursor-pointer focus:outline-none focus:ring-0">
                            <svg class="absolute w-3 h-3 text-white left-1 top-1 opacity-0 peer-checked:opacity-100 pointer-events-none" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[13px] text-slate-700 font-medium">Keep me signed in</span>
                    </label>
                    <svg class="w-3.5 h-3.5 text-slate-400 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>

                <!-- Sign In Button -->
                <button type="submit" class="w-full mt-2 py-2.5 bg-[#90ee90] hover:bg-[#7fdf7f] border border-black rounded-xl text-black font-semibold text-[14px] transition-colors flex justify-center items-center shadow-sm">
                    <span wire:loading.remove wire:target="login">Sign in</span>
                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Signing in...
                    </span>
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="#" class="text-[12px] text-slate-600 hover:text-slate-900 font-medium transition-colors">New to ArchiAgent? Create account</a>
            </div>

            <!-- Separator -->
            <div class="relative mt-8 mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-slate-400 text-[11px] font-medium tracking-wide">Or sign in with</span>
                </div>
            </div>

            <!-- Google Button -->
            <button type="button" class="w-full py-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-semibold text-[14px] transition-colors flex justify-center items-center gap-2.5 shadow-sm">
                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google
            </button>
            
            <div class="text-center mt-6">
                <a href="{{ route('landing') }}" class="text-[11px] text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest font-mono">
                    &larr; Return to Root
                </a>
            </div>
        </div>
    </div>
</div>
