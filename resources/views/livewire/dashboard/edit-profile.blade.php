<div>
    @if($showModal)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm z-[1000]" wire:click="$set('showModal', false)"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white/95 shadow-2xl border-l border-slate-200 flex flex-col h-screen max-h-screen z-[1001]">
                <div class="flex items-start justify-between gap-4 px-5 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Account</p>
                        <h3 class="text-xl font-semibold text-slate-900">Edit Profile</h3>
                        <p class="text-sm text-slate-500 mt-1">Update your personal details and security settings.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-slate-500 hover:text-slate-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <form wire:submit.prevent="updateProfile" class="space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div>
                                @if ($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" class="w-20 h-20 rounded-2xl object-cover border border-slate-200 shadow-sm" alt="preview">
                                @else
                                    <img src="{{ auth()->user()->profile_image_url }}" class="w-20 h-20 rounded-2xl object-cover border border-slate-200 shadow-sm" alt="avatar">
                                @endif
                            </div>

                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-slate-700">Profile Picture</label>
                                <div class="mt-2 flex gap-2">
                                    <input type="file" wire:model="profile_image" accept="image/*" id="profile_image" class="hidden" />
                                    <button type="button" onclick="document.getElementById('profile_image').click()" class="flex-1 px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">Choose file</button>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">PNG, JPG up to 2MB.</p>
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Full name</label>
                                <input type="text" wire:model.defer="name" class="mt-1 block w-full border border-slate-200 bg-slate-50/60 px-3 py-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Email</label>
                                <input type="email" wire:model.defer="email" class="mt-1 block w-full border border-slate-200 bg-slate-50/60 px-3 py-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">New password <span class="text-xs text-slate-500">(leave blank to keep current)</span></label>
                                    <input type="password" wire:model.defer="password" class="mt-1 block w-full border border-slate-200 bg-slate-50/60 px-3 py-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Confirm new password</label>
                                    <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border border-slate-200 bg-slate-50/60 px-3 py-2.5 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 shadow-sm w-full sm:w-auto">Save changes</button>
                            <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2.5 border border-slate-200 rounded-lg font-semibold text-slate-600 hover:bg-slate-50 w-full sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
