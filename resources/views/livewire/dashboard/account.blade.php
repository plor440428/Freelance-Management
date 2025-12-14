<div>
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold">Accounts</h3>
            <p class="text-sm text-slate-600">Manage user accounts in the system.</p>
        </div>
        <div>
            <button wire:click="$set('showCreateModal', true)" class="px-3 py-2 bg-black text-white rounded">Create user</button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y">
            <thead>
                <tr class="text-left text-sm font-medium text-slate-600 bg-slate-50">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700 divide-y">
                @foreach($users as $u)
                    <tr>
                        <td class="px-4 py-3">{{ $u->id }}</td>
                        <td class="px-4 py-3">{{ $u->name }}</td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-slate-100 rounded text-xs">{{ $u->role }}</span></td>
                        <td class="px-4 py-3">{{ $u->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <button wire:click="edit({{ $u->id }})" class="px-2 py-1 border rounded text-sm hover:bg-slate-50">Edit</button>
                            <button wire:click="confirmDelete({{ $u->id }})" class="px-2 py-1 border rounded text-sm text-red-600 hover:bg-red-50">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showCreateModal', false)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Create User</h3>
                    <button wire:click="$set('showCreateModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>
                <div class="p-4">
                    <form wire:submit.prevent="createUser" class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div>
                                @if ($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover border" alt="preview">
                                @else
                                    <div class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center border">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                <input type="file" wire:model="profile_image" accept="image/*" class="mt-2" />
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select wire:model.defer="role" class="mt-1 block w-full border px-3 py-2 rounded">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" wire:model.defer="password" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm password</label>
                            <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border px-3 py-2 rounded" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded">Create</button>
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 border rounded">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditModal', false)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Edit User</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>
                <div class="p-4 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateUser" class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div>
                                @if ($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover border" alt="preview">
                                @else
                                    @php
                                        $editingUser = $users->find($editingUserId);
                                    @endphp
                                    @if ($editingUser && $editingUser->profile_image_url)
                                        <img src="{{ $editingUser->profile_image_url }}" class="w-20 h-20 rounded-full object-cover border" alt="avatar">
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-slate-200 flex items-center justify-center border">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                <input type="file" wire:model="profile_image" accept="image/*" class="mt-2" />
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select wire:model.defer="role" class="mt-1 block w-full border px-3 py-2 rounded">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">New password <span class="text-xs text-slate-500">(leave blank to keep current)</span></label>
                            <input type="password" wire:model.defer="password" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm new password</label>
                            <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border px-3 py-2 rounded" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded">Save</button>
                            <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 border rounded">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete confirmation modal -->
    @if($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
                <div class="p-4">
                    <p class="text-sm text-red-800">Are you sure you want to delete this account? This cannot be undone.</p>
                    <div class="mt-3 flex gap-2">
                        <button wire:click="deleteUser({{ $confirmingDeleteId }})" class="px-3 py-2 bg-red-600 text-white rounded">Yes, delete</button>
                        <button wire:click="$set('confirmingDeleteId', null)" class="px-3 py-2 border rounded">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
