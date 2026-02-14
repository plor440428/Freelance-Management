<div style="font-family: 'IBM Plex Sans Thai', sans-serif;">
    <!-- Notification Toast -->
    <div x-data="{ show: false, type: 'success', message: '' }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @show-notification.window="
            show = true;
            type = $event.detail.type;
            message = $event.detail.message;
            setTimeout(() => show = false, 5000);
         "
         class="fixed top-4 right-4 z-50 max-w-md"
         style="display: none;">
        <div :class="{
            'bg-green-50 border-green-500 text-green-800': type === 'success',
            'bg-red-50 border-red-500 text-red-800': type === 'error',
            'bg-yellow-50 border-yellow-500 text-yellow-800': type === 'warning'
        }" class="border-l-4 p-4 rounded-xl shadow-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg x-show="type === 'success'" class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <svg x-show="type === 'error'" class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <svg x-show="type === 'warning'" class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-8 sm:py-12">
        <div class="w-full max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-5 rounded-2xl overflow-hidden shadow-xl border border-slate-200/80 bg-white">
                <div class="lg:col-span-2 p-8 sm:p-10 lg:p-12 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-white">
                    <div class="text-xs sm:text-sm uppercase tracking-[0.15em] text-slate-300 font-medium">Create</div>
                    <h2 class="mt-5 text-2xl sm:text-3xl font-semibold leading-tight">สมัครสมาชิก
                        <span class="block text-slate-300 text-base sm:text-lg font-normal mt-3">เริ่มต้นจัดการงานและโปรเจกต์อย่างเป็นระบบ</span>
                    </h2>
                    <div class="mt-8 text-sm sm:text-base text-slate-200 space-y-2.5">
                        <p class="flex items-start"><span class="text-slate-400 mr-2">1.</span> กรอกข้อมูลผู้ใช้ให้ครบถ้วน</p>
                        <p class="flex items-start"><span class="text-slate-400 mr-2">2.</span> อัปโหลดหลักฐานการโอน</p>
                        <p class="flex items-start"><span class="text-slate-400 mr-2">3.</span> รอการอนุมัติจากผู้ดูแลระบบ</p>
                    </div>
                </div>

                <div class="lg:col-span-3 p-8 sm:p-10 lg:p-12">
                    <div class="mb-8">
                        <h3 class="text-xl sm:text-2xl font-semibold text-slate-900">สร้างบัญชีใหม่</h3>
                        <p class="mt-2.5 text-sm sm:text-base text-slate-600">กรอกข้อมูลให้ถูกต้องเพื่อความรวดเร็วในการอนุมัติ</p>
                    </div>

                    <form wire:submit.prevent="register" class="space-y-6" novalidate>
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-slate-900">ข้อมูลผู้ใช้</h4>
                                <span class="text-xs text-slate-500">จำเป็นสำหรับการใช้งาน</span>
                            </div>

                            <div>
                                <label for="profile_image" class="block text-sm font-medium text-slate-700 mb-2">รูปโปรไฟล์ (ไม่บังคับ)</label>
                                <div class="flex gap-2">
                                <input
                                    id="profile_image"
                                    type="file"
                                    wire:model.live="profile_image"
                                    accept="image/*"
                                    class="hidden" />
                                <button type="button" onclick="document.getElementById('profile_image').click()" class="flex-1 px-4 py-3 border border-slate-300 rounded-lg shadow-sm text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                    {{ $profile_image ? 'Change Profile Picture' : 'Choose Profile Picture' }}
                                </button>
                            </div>
                            @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                            @if ($profile_image)
                                <div class="mt-4 flex items-center gap-4">
                                    <img src="{{ $profile_image->temporaryUrl() }}" alt="Profile Preview" class="w-16 h-16 rounded-full object-cover border border-slate-200 shadow-sm">
                                    <div class="text-sm text-slate-600">Preview รูปโปรไฟล์</div>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="name" class="text-sm font-medium text-slate-700">ชื่อ-นามสกุล</label>
                                <input
                                    id="name"
                                    type="text"
                                    wire:model.defer="name"
                                    autocomplete="name"
                                    placeholder="Full name"
                                    class="mt-2 appearance-none block w-full px-4 py-3 border {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                @error('name')
                                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-start">
                                            <svg class="h-5 w-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            <p class="ml-2 text-sm text-red-700 font-medium">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="text-sm font-medium text-slate-700">อีเมล</label>
                                <input
                                    id="email"
                                    type="email"
                                    wire:model.blur="email"
                                    autocomplete="username"
                                    placeholder="you@example.com"
                                    class="mt-2 appearance-none block w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                @error('email')
                                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-start">
                                            <svg class="h-5 w-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            <p class="ml-2 text-sm text-red-700 font-medium">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-slate-900">ตั้งรหัสผ่าน</h4>
                                <span class="text-xs text-slate-500">ขั้นต่ำ 6 ตัวอักษร</span>
                            </div>
                            <div>
                                <label for="password" class="text-sm font-medium text-slate-700">รหัสผ่าน</label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        type="password"
                                        wire:model.defer="password"
                                        autocomplete="new-password"
                                        placeholder="Create a strong password"
                                        class="mt-2 appearance-none block w-full px-4 py-3 pr-12 border {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                <button
                                    type="button"
                                    onclick="togglePassword('password', 'eyePassword')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-700">
                                    <svg id="eyePassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                </div>
                                @error('password')
                                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-start">
                                            <svg class="h-5 w-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            <p class="ml-2 text-sm text-red-700 font-medium">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="password_confirmation" class="text-sm font-medium text-slate-700">ยืนยันรหัสผ่าน</label>
                                <div class="relative">
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        wire:model.defer="password_confirmation"
                                        autocomplete="new-password"
                                        placeholder="Confirm your password"
                                        class="mt-2 appearance-none block w-full px-4 py-3 pr-12 border {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-slate-300' }} rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                    <button
                                        type="button"
                                        onclick="togglePassword('password_confirmation', 'eyePasswordConfirm')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-700">
                                        <svg id="eyePasswordConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-slate-900">แพ็กเกจและการชำระเงิน</h4>
                                <span class="text-xs text-slate-500">ชำระครั้งเดียว</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="role" class="block text-sm font-medium text-slate-700 mb-2">ประเภทบัญชี</label>
                                    <select
                                        id="role"
                                        wire:model.live="role"
                                        class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                        <option value="customer">Customer</option>
                                        <option value="freelance">Freelancer</option>
                                    </select>
                                    @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Payment Plan</label>
                                    <div class="p-4 border border-slate-200 bg-slate-50 rounded-lg">
                                        <div class="font-semibold text-slate-900">Lifetime Access</div>
                                        <div class="text-3xl font-bold text-slate-900 mt-2">฿{{ number_format($this->amount, 0) }}</div>
                                        <div class="text-xs text-slate-600 mt-1">Pay once, use forever</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-sm text-emerald-900">
                                            <p class="font-semibold mb-2">ข้อมูลบัญชีสำหรับโอนเงิน</p>
                                            <div class="space-y-1">
                                                <p><strong>ธนาคาร:</strong> กสิกรไทย (KBANK)</p>
                                                <p><strong>ชื่อบัญชี:</strong> บริษัท ฟรีแลนซ์แมน จำกัด</p>
                                                <p><strong>เลขที่บัญชี:</strong> 123-4-56789-0</p>
                                                <p><strong>ประเภทบัญชี:</strong> ออมทรัพย์</p>
                                                <p><strong>จำนวนเงิน:</strong> ฿{{ number_format($this->amount, 0) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    อัปโหลดสลิปการโอนเงิน <span class="text-red-600">*</span>
                                </label>
                                <div class="flex gap-2">
                                <input
                                    id="payment_slip"
                                    type="file"
                                    wire:model.live="payment_slip"
                                    accept="image/*,application/pdf"
                                    class="hidden" />
                                    <button type="button" onclick="document.getElementById('payment_slip').click()" class="flex-1 px-4 py-3 border-2 border-dashed border-slate-300 rounded-lg shadow-sm text-slate-700 hover:border-slate-900 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                    {{ $payment_slip ? 'เปลี่ยนสลิป' : 'อัปโหลดสลิปการโอนเงิน' }}
                                </button>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">รองรับไฟล์รูปภาพหรือ PDF ขนาดไม่เกิน 5MB</p>
                                @error('payment_slip') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                                @if ($payment_slip)
                                    <div class="mt-4 flex items-center gap-4">
                                        <img src="{{ $payment_slip->temporaryUrl() }}" alt="Slip Preview" class="w-28 rounded-lg border border-slate-200 shadow">
                                        <div class="text-sm text-slate-600">ตรวจสอบความชัดเจนของสลิปก่อนส่ง</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                class="w-full sm:w-auto cursor-pointer flex justify-center items-center py-3 px-6 rounded-lg text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                                <span wire:loading.remove>Create Account</span>
                                <div wire:loading class="inline-flex flex-row items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white inline-flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <div>Creating account...</div>
                                </div>
                            </button>
                        </div>

                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 hover:underline">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);

    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>

<script>
    window.addEventListener('registration-success', function() {
        Swal.fire({
            icon: 'success',
            title: 'ลงทะเบียนสำเร็จ!',
            html: `
                <div class="text-left space-y-3 mt-4">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-gray-700">
                            <strong>บันทึกข้อมูลบัญชีของท่านเรียบร้อยแล้ว</strong>
                        </p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-gray-700">
                            กรุณารอเจ้าหน้าที่ตรวจสอบข้อมูล
                        </p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-purple-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <p class="text-sm text-gray-700">
                            <strong>เราจะส่งผลการตรวจสอบผ่านอีเมลที่ท่านลงทะเบียน</strong>
                        </p>
                    </div>
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-800">
                            💡 <strong>หมายเหตุ:</strong> กระบวนการตรวจสอบอาจใช้เวลา 1-2 วันทำการ กรุณาตรวจสอบอีเมลของท่านเป็นประจำ หรือหากไม่เจอกรุณาตรวจสอบในถังขยะหรือสแปม
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'ไปหน้าเข้าสู่ระบบ',
            cancelButtonText: 'ปิด',
            confirmButtonColor: '#000000',
            cancelButtonColor: '#6B7280',
            allowOutsideClick: false,
            allowEscapeKey: false,
            width: '600px'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('login') }}';
            }
        });
    });
</script>
