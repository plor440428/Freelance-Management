<div>
    <div class="min-h-screen flex items-center justify-center px-6 py-12 ">
        <div class="w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-5 rounded-2xl overflow-hidden shadow-2xl border border-slate-200 bg-white">
                <div class="md:col-span-2 p-6 sm:p-8 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white">
                    <div class="text-sm uppercase tracking-[0.2em] text-slate-300">Reset</div>
                    <h2 class="mt-4 text-2xl font-bold leading-tight">ลืมรหัสผ่าน
                        <span class="block text-slate-300 text-base font-medium mt-2">เริ่มต้นใหม่ได้ง่ายในไม่กี่ขั้นตอน</span>
                    </h2>
                    <div class="mt-6 text-sm text-slate-200 space-y-2">
                        <p>1) กรอกอีเมลที่ลงทะเบียนไว้</p>
                        <p>2) รับลิงก์ในอีเมลเพื่อรีเซ็ต</p>
                        <p>3) ตั้งรหัสผ่านใหม่ได้ทันที</p>
                    </div>
                </div>

                <div class="md:col-span-3 p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-slate-900">รับลิงก์รีเซ็ตรหัสผ่าน</h3>
                        <p class="mt-2 text-sm text-slate-600">กรอกอีเมลเพื่อรับลิงก์สำหรับตั้งรหัสผ่านใหม่</p>
                    </div>

                    <form wire:submit.prevent="submit" class="space-y-6" novalidate>
                        <div>
                            <label for="email" class="text-sm font-medium text-slate-700">อีเมล</label>
                            <input
                                id="email"
                                type="email"
                                wire:model.defer="email"
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="mt-2 appearance-none block w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
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
