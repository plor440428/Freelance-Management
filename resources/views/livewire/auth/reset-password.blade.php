<div>
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-5 rounded-2xl overflow-hidden shadow-2xl border border-slate-200 bg-white">
                <div class="md:col-span-2 p-6 sm:p-8 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white">
                    <div class="text-sm uppercase tracking-[0.2em] text-slate-300">New Password</div>
                    <h2 class="mt-4 text-2xl font-bold leading-tight">ตั้งรหัสผ่านใหม่
                        <span class="block text-slate-300 text-base font-medium mt-2">รักษาความปลอดภัยของบัญชีให้ดีที่สุด</span>
                    </h2>
                    <div class="mt-6 text-sm text-slate-200 space-y-2">
                        <p>แนะนำใช้รหัสผ่านที่คาดเดายาก</p>
                        <p>อย่างน้อย 6 ตัวอักษรขึ้นไป</p>
                    </div>
                </div>

                <div class="md:col-span-3 p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-slate-900">กรอกรหัสผ่านใหม่</h3>
                        <p class="mt-2 text-sm text-slate-600">ใช้รหัสผ่านที่คุณไม่เคยใช้มาก่อนเพื่อความปลอดภัย</p>
                    </div>

                    <form wire:submit.prevent="resetPassword" class="space-y-6" novalidate>
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

                        <div>
                            <label for="password" class="text-sm font-medium text-slate-700">รหัสผ่านใหม่</label>
                            <input
                                id="password"
                                type="password"
                                wire:model.defer="password"
                                autocomplete="new-password"
                                placeholder="รหัสผ่านใหม่"
                                class="mt-2 appearance-none block w-full px-4 py-3 border {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-sm font-medium text-slate-700">ยืนยันรหัสผ่านใหม่</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                wire:model.defer="password_confirmation"
                                autocomplete="new-password"
                                placeholder="ยืนยันรหัสผ่านใหม่"
                                class="mt-2 appearance-none block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto cursor-pointer flex justify-center items-center py-3 px-6 rounded-lg text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                                <span wire:loading.remove>บันทึกรหัสผ่านใหม่</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div class="ml-2">กำลังบันทึก...</div>
                                </div>
                            </button>
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 hover:underline">กลับไปหน้าเข้าสู่ระบบ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
