<div>
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
        }" class="border-l-4 p-4 rounded shadow-lg">
            <div class="flex items-start">
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">&times;</button>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-4xl">
            <div class="rounded-2xl overflow-hidden shadow-2xl border border-slate-200 bg-white">
                <div class="p-6 sm:p-8 bg-slate-900 text-white">
                    <h2 class="text-2xl font-bold">แก้ไขข้อมูลการสมัคร</h2>
                    <p class="mt-2 text-sm text-slate-300">กรุณาแก้ไขข้อมูลให้ครบถ้วนเพื่อให้แอดมินพิจารณาใหม่</p>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    @if($user->rejection_reason)
                        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <div class="font-semibold mb-1">เหตุผลที่ไม่อนุมัติ</div>
                            <div>{{ $user->rejection_reason }}</div>
                        </div>
                    @endif

                    <form wire:submit.prevent="submitRevision" class="space-y-6" novalidate>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="text-sm font-medium text-slate-700">ชื่อ-นามสกุล</label>
                                <input
                                    id="name"
                                    type="text"
                                    wire:model.defer="name"
                                    class="mt-2 block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="email" class="text-sm font-medium text-slate-700">อีเมล</label>
                                <input
                                    id="email"
                                    type="email"
                                    wire:model.defer="email"
                                    class="mt-2 block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-700 mb-2">ประเภทบัญชี</label>
                            <select
                                id="role"
                                wire:model.defer="role"
                                class="block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="text-sm font-medium text-slate-700">รหัสผ่านใหม่ (ถ้าต้องการเปลี่ยน)</label>
                                <input
                                    id="password"
                                    type="password"
                                    wire:model.defer="password"
                                    class="mt-2 block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                                @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="text-sm font-medium text-slate-700">ยืนยันรหัสผ่านใหม่</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    wire:model.defer="password_confirmation"
                                    class="mt-2 block w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="rounded-lg border border-slate-200 p-4">
                                <label class="text-sm font-medium text-slate-700">รูปโปรไฟล์ใหม่ (ถ้าต้องการ)</label>
                                <div class="mt-3 flex items-center gap-3">
                                    <input
                                        id="profile_image"
                                        type="file"
                                        wire:model.live="profile_image"
                                        accept="image/*"
                                        class="hidden" />
                                    <button type="button" onclick="document.getElementById('profile_image').click()"
                                            class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">
                                        เลือกไฟล์รูปโปรไฟล์
                                    </button>
                                    <span class="text-xs text-slate-500" wire:loading.remove wire:target="profile_image">
                                        {{ $profile_image ? $profile_image->getClientOriginalName() : 'ยังไม่ได้เลือกไฟล์' }}
                                    </span>
                                    <span class="text-xs text-slate-500" wire:loading wire:target="profile_image">กำลังอัปโหลด...</span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">รองรับไฟล์ JPG, PNG, GIF ขนาดไม่เกิน 2MB</p>
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="rounded-lg border border-slate-200 p-4">
                                <label class="text-sm font-medium text-slate-700">อัปโหลดสลิปใหม่ (ถ้ามี)</label>
                                <div class="mt-3 flex items-center gap-3">
                                    <input
                                        id="payment_slip"
                                        type="file"
                                        wire:model.live="payment_slip"
                                        accept="image/*,application/pdf"
                                        class="hidden" />
                                    <button type="button" onclick="document.getElementById('payment_slip').click()"
                                            class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50">
                                        เลือกไฟล์สลิป
                                    </button>
                                    <span class="text-xs text-slate-500" wire:loading.remove wire:target="payment_slip">
                                        {{ $payment_slip ? $payment_slip->getClientOriginalName() : 'ยังไม่ได้เลือกไฟล์' }}
                                    </span>
                                    <span class="text-xs text-slate-500" wire:loading wire:target="payment_slip">กำลังอัปโหลด...</span>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">รองรับไฟล์ภาพหรือ PDF ขนาดไม่เกิน 5MB</p>
                                @error('payment_slip') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-60 cursor-not-allowed"
                                wire:target="submitRevision,profile_image,payment_slip"
                                class="w-full sm:w-auto px-6 py-3 rounded-lg text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 inline-flex items-center gap-2">
                                <svg wire:loading wire:target="submitRevision" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="submitRevision">ส่งข้อมูลแก้ไข</span>
                                <span wire:loading wire:target="submitRevision">กำลังส่ง...</span>
                            </button>
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-slate-900 hover:underline">กลับหน้าเข้าสู่ระบบ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('revision-submitted', function(event) {
        const loginUrl = event.detail?.loginUrl || '{{ route('login') }}';
        Swal.fire({
            icon: 'success',
            title: 'ส่งข้อมูลแก้ไขสำเร็จ',
            text: 'ระบบจะพาคุณกลับไปหน้าเข้าสู่ระบบ',
            confirmButtonText: 'กลับไปหน้าเข้าสู่ระบบ',
        }).then(() => {
            window.location.href = loginUrl;
        });
    });
</script>
