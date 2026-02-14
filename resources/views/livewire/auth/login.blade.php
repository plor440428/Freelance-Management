<div style="font-family: 'IBM Plex Sans Thai', sans-serif;">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12">
        <div class="w-full max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-5 rounded-2xl overflow-hidden shadow-xl border border-slate-200/80 bg-white">
                <div class="lg:col-span-2 p-8 sm:p-10 lg:p-12 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white">
                    <div class="text-xs sm:text-sm uppercase tracking-[0.15em] text-slate-300 font-medium">Welcome</div>
                    <h2 class="mt-5 text-2xl sm:text-3xl font-semibold leading-tight">ยินดีต้อนรับกลับมา
                        <span class="block text-slate-300 text-base sm:text-lg font-normal mt-3">เข้าสู่ระบบเพื่อจัดการงานและโปรเจกต์ของคุณ</span>
                    </h2>
                    <div class="mt-8 text-sm sm:text-base text-slate-200 space-y-2.5">
                        <p class="flex items-start"><span class="text-slate-400 mr-2">•</span> เข้าใช้งานได้เฉพาะบัญชีที่อนุมัติแล้ว</p>
                        <p class="flex items-start"><span class="text-slate-400 mr-2">•</span> หากลืมรหัสผ่านสามารถกดรีเซ็ตได้</p>
                    </div>
                </div>

                <div class="lg:col-span-3 p-8 sm:p-10 lg:p-12">
                    <div class="mb-8">
                        <h3 class="text-xl sm:text-2xl font-semibold text-slate-900">เข้าสู่ระบบ</h3>
                        <p class="mt-2.5 text-sm sm:text-base text-slate-600">กรอกอีเมลและรหัสผ่านเพื่อเข้าใช้งาน</p>
                    </div>

                    <form wire:submit.prevent="login" class="space-y-5" novalidate>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">อีเมล</label>
                            <input
                                id="email"
                                type="email"
                                wire:model.defer="email"
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="appearance-none block w-full px-4 py-3.5 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 transition-all focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900 hover:border-slate-400" />
                            @error('email') <p class="mt-2 text-sm text-red-600 flex items-center"><svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">รหัสผ่าน</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    wire:model.defer="password"
                                    autocomplete="current-password"
                                    placeholder="Your password"
                                    class="appearance-none block w-full px-4 py-3.5 pr-12 border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 transition-all focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900 hover:border-slate-400" />
                                <button
                                    type="button"
                                    onclick="togglePassword('password', 'toggleIcon')"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-700">
                                    <svg id="toggleIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-red-600 flex items-center"><svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-1">
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="remember" type="checkbox" wire:model="remember" class="h-4 w-4 text-slate-900 border-slate-300 rounded focus:ring-slate-900 cursor-pointer" />
                                <span class="ml-2.5 text-sm text-slate-600">จำฉันไว้ในระบบ</span>
                            </label>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-slate-700 hover:text-slate-900 hover:underline transition-colors">ลืมรหัสผ่าน?</a>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-2">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto cursor-pointer flex justify-center items-center py-3.5 px-8 rounded-xl text-white font-medium bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove>เข้าสู่ระบบ</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div class="ml-2.5">กำลังเข้าสู่ระบบ...</div>
                                </div>
                            </button>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 hover:underline transition-colors">สร้างบัญชีใหม่</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</div>
