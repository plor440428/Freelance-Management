<div style="font-family: 'IBM Plex Sans Thai', sans-serif;">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12">
        <div class="w-full max-w-4xl">
            <div class="grid grid-cols-1 lg:grid-cols-5 rounded-2xl overflow-hidden shadow-xl border border-slate-200/80 bg-white">
                <div class="lg:col-span-2 p-8 sm:p-10 lg:p-12 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white">
                    <div class="text-xs sm:text-sm uppercase tracking-[0.15em] text-slate-300 font-medium">Reset</div>
                    <h2 class="mt-5 text-2xl sm:text-3xl font-semibold leading-tight">ลืมรหัสผ่าน
                        <span class="block text-slate-300 text-base sm:text-lg font-normal mt-3">เริ่มต้นใหม่ได้ง่ายในไม่กี่ขั้นตอน</span>
                    </h2>
                    <div class="mt-8 text-sm sm:text-base text-slate-200 space-y-2.5">
                        <p class="flex items-start"><span class="text-slate-400 mr-2">1.</span> กรอกอีเมลที่ลงทะเบียนไว้</p>
                        <p class="flex items-start"><span class="text-slate-400 mr-2">2.</span> รับลิงก์ในอีเมลเพื่อรีเซ็ต</p>
                        <p class="flex items-start"><span class="text-slate-400 mr-2">3.</span> ตั้งรหัสผ่านใหม่ได้ทันที</p>
                    </div>
                </div>

                <div class="lg:col-span-3 p-8 sm:p-10 lg:p-12">
                    <div class="mb-8">
                        <h3 class="text-xl sm:text-2xl font-semibold text-slate-900">รับลิงก์รีเซ็ตรหัสผ่าน</h3>
                        <p class="mt-2.5 text-sm sm:text-base text-slate-600">กรอกอีเมลเพื่อรับลิงก์สำหรับตั้งรหัสผ่านใหม่</p>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-5" novalidate>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">อีเมล</label>
                            <input
                                id="email"
                                type="email"
                                wire:model.defer="email"
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="appearance-none block w-full px-4 py-3.5 border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-xl shadow-sm placeholder-slate-400 transition-all focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900 hover:border-slate-400" />
                            @error('email') <p class="mt-2 text-sm text-red-600 flex items-center"><svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto cursor-pointer flex justify-center items-center py-3 px-6 rounded-lg text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                                <span wire:loading.remove>ส่งลิงก์รีเซ็ต</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div class="ml-2">กำลังส่ง...</div>
                                </div>
                            </button>
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 hover:underline">กลับไปหน้าเข้าสู่ระบบ</a>
                        </div>
                    </form>

                    <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                        <p>หมายเหตุ: ลิงก์รีเซ็ตจะถูกส่งเฉพาะบัญชีที่ได้รับการอนุมัติแล้วเท่านั้น</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('password-link-sent', (event) => {
            const message = event?.detail?.message || 'ส่งลิงก์รีเซ็ตรหัสผ่านสำเร็จแล้ว';
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'ส่งลิงก์สำเร็จ',
                    text: message,
                    confirmButtonText: 'เข้าใจแล้ว',
                    confirmButtonColor: '#0f172a'
                });
            }
        });
    </script>
</div>
