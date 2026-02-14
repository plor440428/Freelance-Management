<div>
    <div class="bg-gradient-to-r from-white via-slate-50 to-white border border-slate-200/60 rounded-2xl p-6 mb-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Account Center</p>
                <h3 class="dash-title text-2xl font-semibold text-slate-900 mt-2">Accounts</h3>
                <p class="text-sm text-slate-600 mt-1">Manage user accounts in the system.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
            @if($search || $filterRole || $filterDate)
                <button wire:click="clearFilters" class="px-4 py-2 border border-amber-300 text-amber-700 rounded-lg hover:bg-amber-50">Clear Filters</button>
            @endif
                <button wire:click="$set('showCreateModal', true)" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 shadow-sm">Create user</button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="dash-panel rounded-2xl p-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-slate-800">Filters</h4>
            <span class="text-xs text-slate-500">Quick refine the list</span>
        </div>
        <div class="dash-grid grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search (Name/Email)</label>
                <input type="text" wire:model.live="search" placeholder="Search..." class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm bg-white/90 focus:outline-none focus:ring-2 focus:ring-slate-900/20" />
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select wire:model.live="filterRole" class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm bg-white/90 focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="freelance">Freelancer</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <!-- Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                <input type="date" wire:model.live="filterDate" class="w-full border border-slate-200 px-3 py-2 rounded-lg text-sm bg-white/90 focus:outline-none focus:ring-2 focus:ring-slate-900/20" />
            </div>

            <!-- Items per page info -->
            <div class="flex items-end">
                <div class="text-sm text-slate-600">
                    <p>Showing <strong>{{ $users->count() }}</strong> of <strong>{{ $users->total() }}</strong> users</p>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200">
            <thead>
                <tr class="text-left text-sm font-medium text-slate-600 bg-slate-50/80">
                    <th class="px-4 py-3 cursor-pointer hover:bg-slate-100" wire:click="sortBy('id')">
                        ID
                        @if($sortBy === 'id')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-3">Profile</th>
                    <th class="px-4 py-3 cursor-pointer hover:bg-slate-100" wire:click="sortBy('name')">
                        Name
                        @if($sortBy === 'name')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-3 cursor-pointer hover:bg-slate-100" wire:click="sortBy('email')">
                        Email
                        @if($sortBy === 'email')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-3 cursor-pointer hover:bg-slate-100" wire:click="sortBy('role')">
                        Role
                        @if($sortBy === 'role')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-3 cursor-pointer hover:bg-slate-100" wire:click="sortBy('created_at')">
                        Created
                        @if($sortBy === 'created_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $u->id }}</td>
                        <td class="px-4 py-3">
                            <img src="{{ $u->profile_image_url }}" alt="{{ $u->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200" title="{{ $u->name }}" />
                        </td>
                        <td class="px-4 py-3">{{ $u->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $u->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $u->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : ($u->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $u->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <button wire:click="viewSubscription({{ $u->id }})" class="px-2.5 py-1 border border-blue-200 rounded-lg text-sm hover:bg-blue-50 text-blue-700">Subscription</button>
                            <button wire:click="edit({{ $u->id }})" class="px-2.5 py-1 border border-slate-200 rounded-lg text-sm hover:bg-slate-50">Edit</button>
                            <button wire:click="confirmDelete({{ $u->id }})" class="px-2.5 py-1 border border-red-200 rounded-lg text-sm text-red-600 hover:bg-red-50">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                            No users found. Try adjusting your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="$set('showCreateModal', false)"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white/95 shadow-2xl border-l border-slate-200 flex flex-col h-screen max-h-screen z-[1001]">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account</p>
                        <h3 class="text-lg font-semibold text-slate-900 mt-1">Create User</h3>
                    </div>
                    <button wire:click="$set('showCreateModal', false)" class="text-slate-600 hover:text-slate-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
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
                                <div class="mt-2 flex gap-2">
                                    <input type="file" wire:model="profile_image" accept="image/*" id="profile_image_create" class="hidden" />
                                    <button type="button" onclick="document.getElementById('profile_image_create').click()" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50">Choose file</button>
                                </div>
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select wire:model.defer="role" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" wire:model.defer="password" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm password</label>
                            <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">Create</button>
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 border border-slate-200 rounded-lg">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="$set('showEditModal', false)"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white/95 shadow-2xl border-l border-slate-200 flex flex-col h-screen max-h-screen z-[1001]">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Account</p>
                        <h3 class="text-lg font-semibold text-slate-900 mt-1">Edit User</h3>
                    </div>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-600 hover:text-slate-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
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
                                <div class="mt-2 flex gap-2">
                                    <input type="file" wire:model="profile_image" accept="image/*" id="profile_image_edit" class="hidden" />
                                    <button type="button" onclick="document.getElementById('profile_image_edit').click()" class="flex-1 px-3 py-2 border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50">Choose file</button>
                                </div>
                                @error('profile_image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select wire:model.defer="role" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg">
                                <option value="customer">Customer</option>
                                <option value="freelance">Freelancer</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">New password <span class="text-xs text-slate-500">(leave blank to keep current)</span></label>
                            <input type="password" wire:model.defer="password" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm new password</label>
                            <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border border-slate-200 px-3 py-2 rounded-lg" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">Save</button>
                            <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 border border-slate-200 rounded-lg">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete confirmation modal -->
    @if($confirmingDeleteId)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-md bg-white/95 shadow-2xl border-l border-slate-200 flex flex-col h-screen max-h-screen z-[1001]">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 bg-red-50">
                    <h3 class="text-lg font-semibold text-slate-900">Delete Account</h3>
                    <button wire:click="$set('confirmingDeleteId', null)" class="text-slate-600 hover:text-slate-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <p class="text-sm text-red-800 font-medium">Are you sure you want to delete this account? This cannot be undone.</p>
                    <div class="mt-4 flex gap-2">
                        <button wire:click="deleteUser({{ $confirmingDeleteId }})" class="px-4 py-2 bg-red-600 text-white rounded-lg">Yes, delete</button>
                        <button wire:click="$set('confirmingDeleteId', null)" class="px-4 py-2 border border-slate-200 rounded-lg">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Subscription Modal -->
    @if($showSubscriptionModal && $viewingUser)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="closeSubscriptionModal"></div>
            <div class="absolute inset-y-0 right-0 w-full max-w-4xl bg-white/95 shadow-2xl border-l border-slate-200 flex flex-col h-screen max-h-screen z-[1001]">
                <div class="flex items-center justify-between px-5 py-4 border-b bg-white/95">
                    <h3 class="text-lg font-semibold">Subscription Details - {{ $viewingUser->name }}</h3>
                    <button wire:click="closeSubscriptionModal" class="text-slate-600 hover:text-slate-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <!-- User Info -->
                    <div class="mb-6 bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-600">User:</span>
                                <span class="font-medium ml-2">{{ $viewingUser->name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-600">Email:</span>
                                <span class="font-medium ml-2">{{ $viewingUser->email }}</span>
                            </div>
                            <div>
                                <span class="text-slate-600">Role:</span>
                                <span class="font-medium ml-2 px-2 py-1 rounded text-xs {{ $viewingUser->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($viewingUser->role) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-slate-600">Account Status:</span>
                                <span class="font-medium ml-2 px-2 py-1 rounded text-xs {{ $viewingUser->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $viewingUser->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    <div>
                        <h4 class="font-semibold text-lg mb-4">Payment History</h4>

                        @if($viewingUser->paymentProofs->isEmpty())
                            <div class="text-center py-8 text-slate-500 bg-slate-50 rounded border border-slate-200">
                                <p>No payment records found</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($viewingUser->paymentProofs as $proof)
                                    <div class="border border-slate-200 rounded-lg p-4 {{ $proof->status === 'approved' ? 'bg-green-50' : ($proof->status === 'rejected' ? 'bg-red-50' : 'bg-yellow-50') }}">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h5 class="font-semibold text-lg">{{ ucfirst($proof->subscription_type) }} Subscription</h5>
                                                <p class="text-2xl font-bold text-green-600">฿{{ number_format($proof->amount, 2) }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $proof->status === 'approved' ? 'bg-green-600 text-white' : ($proof->status === 'rejected' ? 'bg-red-600 text-white' : 'bg-yellow-600 text-white') }}">
                                                {{ ucfirst($proof->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                                            <div>
                                                <span class="text-slate-600">Submitted:</span>
                                                <span class="font-medium ml-2">{{ $proof->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                            @if($proof->approved_at)
                                                <div>
                                                    <span class="text-slate-600">{{ ucfirst($proof->status) }} At:</span>
                                                    <span class="font-medium ml-2">{{ $proof->approved_at->format('M d, Y H:i') }}</span>
                                                </div>
                                            @endif
                                            @if($proof->approver)
                                                <div>
                                                    <span class="text-slate-600">{{ ucfirst($proof->status) }} By:</span>
                                                    <span class="font-medium ml-2">{{ $proof->approver->name }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if($proof->admin_note)
                                            <div class="mb-3">
                                                <span class="text-slate-600 text-sm font-semibold">Admin Note:</span>
                                                <p class="mt-1 text-sm bg-white border border-slate-300 rounded p-2">{{ $proof->admin_note }}</p>
                                            </div>
                                        @endif

                                        @if($proof->proof_file)
                                            <div>
                                                <span class="text-slate-600 text-sm font-semibold">Payment Slip:</span>
                                                <div class="mt-2 border border-slate-300 rounded-lg p-2 bg-white">
                                                    <img src="{{ $proof->proof_file_url }}" alt="Payment Slip" class="max-w-full h-auto rounded shadow">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button wire:click="closeSubscriptionModal" class="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
