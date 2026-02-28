<div class="space-y-6">
    <div class="bg-gradient-to-r from-white via-slate-50 to-white border border-slate-200/70 rounded-2xl p-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Approval Center</p>
                <h3 class="dash-title text-2xl font-semibold text-slate-900 mt-2">User Approvals</h3>
                <p class="text-sm text-slate-600 mt-1">Review pending signups and manage access.</p>
            </div>
            <div class="text-xs text-slate-500">Updated {{ now()->format('M d, Y H:i') }}</div>
        </div>
    </div>

    <div wire:loading.flex wire:target="filterStatus,previousPage,nextPage,gotoPage,viewUser" class="mb-4 items-center gap-2 text-sm text-slate-600">
        <svg class="h-4 w-4 animate-spin text-slate-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <span>กำลังโหลดข้อมูล...</span>
    </div>

    <!-- Filter Tabs -->
    <div>
        <div class="bg-white/80 rounded-2xl border border-slate-200/70 p-2 flex flex-wrap gap-2">
            <button wire:click="$set('filterStatus', 'pending')"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filterStatus === 'pending' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Pending
            </button>
            <button wire:click="$set('filterStatus', 'approved')"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filterStatus === 'approved' ? 'bg-green-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Approved
            </button>
            <button wire:click="$set('filterStatus', 'rejected')"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filterStatus === 'rejected' ? 'bg-red-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                Rejected
            </button>
            <button wire:click="$set('filterStatus', 'all')"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition {{ $filterStatus === 'all' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                All
            </button>
        </div>
    </div>

    <!-- Pending Users List -->
    @if(($filterStatus === 'pending' || $filterStatus === 'all') && $filterStatus !== 'all')
        <div class="dash-panel rounded-2xl overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <h4 class="font-semibold text-lg">
                    @if($filterStatus === 'all')
                        Pending Approvals
                    @else
                        Pending Approvals ({{ $pendingUsers->total() }})
                    @endif
                </h4>
            </div>

            @if($pendingUsers->isEmpty() && !collect($users)->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No pending approvals</p>
                </div>
            @elseif($pendingUsers->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No pending approvals</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Subscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($pendingUsers as $user)
                            @php
                                $proof = $user->paymentProofs->first();
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-10 h-10 rounded-full mr-3" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold mr-3">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium">{{ $user->name }}</div>
                                            <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($proof)
                                        <span class="text-sm">Lifetime Access</span>
                                    @else
                                        <span class="text-sm text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($proof)
                                        <span class="font-semibold">฿{{ number_format($proof->amount, 2) }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($proof)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $proof->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                               ($proof->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($proof->status) }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="viewUser({{ $user->id }})"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $pendingUsers->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- Approved Users List -->
    @if(($filterStatus === 'approved' || $filterStatus === 'all') && $filterStatus !== 'all')
        <div class="dash-panel rounded-2xl overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <h4 class="font-semibold text-lg">
                    @if($filterStatus === 'all')
                        Approved Users
                    @else
                        Approved Users ({{ $approvedUsers->total() }})
                    @endif
                </h4>
            </div>

            @if($approvedUsers->isEmpty() && !collect($users)->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No approved users</p>
                </div>
            @elseif($approvedUsers->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No approved users</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Subscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Approved At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Approved By</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($approvedUsers as $user)
                            @php
                                $proof = $user->paymentProofs->first();
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($proof)
                                        Lifetime Access
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if($proof)
                                        ฿{{ number_format($proof->amount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->approved_at?->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->approver?->name ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $approvedUsers->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- Rejected Users List -->
    @if($filterStatus === 'rejected')
        <div class="dash-panel rounded-2xl overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <h4 class="font-semibold text-lg">Rejected Users ({{ $rejectedUsers->total() }})</h4>
            </div>

            @if($rejectedUsers->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No rejected users</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Admin Note</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Rejected At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($rejectedUsers as $user)
                            @php
                                $proof = $user->paymentProofs->first();
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    @if($proof)
                                        ฿{{ number_format($proof->amount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($proof)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            {{ ucfirst($proof->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <span title="{{ $user->rejection_reason ?? '-' }}" class="truncate block">
                                        {{ $user->rejection_reason ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->rejected_at?->format('M d, Y H:i') ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $rejectedUsers->links() }}
                </div>
            @endif
        </div>
    @endif

    <!-- All Users List - Grouped by Status -->
    @if($filterStatus === 'all')
        @php
            $allPending = collect();
            $allApproved = collect();
            $allRejected = collect();
            
            foreach($users as $user) {
                if($user->is_approved) {
                    $allApproved->push($user);
                } elseif($user->rejection_reason) {
                    $allRejected->push($user);
                } else {
                    $allPending->push($user);
                }
            }
        @endphp

        <!-- Pending Users in All Tab -->
        @if($allPending->isNotEmpty())
            <div class="dash-panel rounded-2xl overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h4 class="font-semibold text-lg">Pending Approvals ({{ $allPending->count() }})</h4>
                </div>

                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($allPending as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <button wire:click="viewUser({{ $user->id }})"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Approved Users in All Tab -->
        @if($allApproved->isNotEmpty())
            <div class="dash-panel rounded-2xl overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h4 class="font-semibold text-lg">Approved Users ({{ $allApproved->count() }})</h4>
                </div>

                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($allApproved as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Approved</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-400 text-sm">-</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Rejected Users in All Tab -->
        @if($allRejected->isNotEmpty())
            <div class="dash-panel rounded-2xl overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h4 class="font-semibold text-lg">Rejected Users ({{ $allRejected->count() }})</h4>
                </div>

                <table class="w-full">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($allRejected as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($user->profile_image_path)
                                            <img src="{{ $user->profile_image_url }}"
                                                 class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Rejected</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-400 text-sm">-</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if($allPending->isEmpty() && $allApproved->isEmpty() && $allRejected->isEmpty())
            <div class="dash-panel rounded-2xl overflow-hidden p-8 text-center text-slate-500">
                <p>No users</p>
            </div>
        @endif
    @endif

    <!-- User Detail Modal -->
    @if($showUserDetail && $selectedUser)
        <div class="fixed inset-0 z-[1000] overflow-hidden" wire:keydown.escape.window="closeUserDetail" tabindex="-1">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="closeUserDetail"></div>
            <div class="absolute inset-y-0 right-0 h-full w-full max-w-3xl bg-white shadow-2xl ring-1 ring-slate-200 flex flex-col z-[1001]" wire:click.stop>
                <div wire:loading.flex wire:target="approveUser,rejectUser" class="absolute inset-0 z-10 bg-white/70 items-center justify-center">
                    <div class="flex items-center gap-2 text-sm text-slate-700">
                        <svg class="h-5 w-5 animate-spin text-slate-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>กำลังบันทึก...</span>
                    </div>
                </div>
                <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-gradient-to-r from-slate-50 to-white shrink-0">
                    <h3 class="text-xl font-semibold text-slate-900">Review Registration</h3>
                    <button type="button" wire:click="closeUserDetail" class="text-slate-400 hover:text-slate-600 transition-colors" aria-label="Close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 py-5" style="max-height: calc(100vh - 80px);">
                    <!-- User Info -->
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            @if($selectedUser->profile_image_path)
                                <img src="{{ $selectedUser->profile_image_url }}"
                                     class="w-20 h-20 rounded-full mr-4" alt="{{ $selectedUser->name }}">
                            @else
                                <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold mr-4">
                                    {{ substr($selectedUser->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-2xl font-bold">{{ $selectedUser->name }}</h4>
                                <p class="text-slate-600">{{ $selectedUser->email }}</p>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full mt-2 inline-block
                                    {{ $selectedUser->role === 'freelance' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($selectedUser->role) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-600">Registered:</span>
                                <span class="font-medium">{{ $selectedUser->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            @if($selectedProof)
                                <div>
                                    <span class="text-slate-600">Plan:</span>
                                    <span class="font-medium">Lifetime Access</span>
                                </div>
                                <div>
                                    <span class="text-slate-600">Amount:</span>
                                    <span class="font-medium text-lg text-green-600">฿{{ number_format($selectedProof->amount, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-600">Status:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $selectedProof->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                           ($selectedProof->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($selectedProof->status) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Slip -->
                    @if($selectedProof && $selectedProof->proof_file)
                        <div class="mb-6">
                            <h5 class="font-semibold mb-3 text-lg text-slate-900">Payment Slip</h5>
                            <div class="border border-slate-200 rounded-xl p-4 bg-slate-50 overflow-hidden">
                                <img src="{{ $selectedProof->proof_file_url }}"
                                     alt="Payment Slip"
                                     class="w-full max-h-[600px] object-contain rounded-lg shadow-sm">
                            </div>
                        </div>
                    @endif

                    <!-- Show Old Payment Proof if User Submitted Revision -->
                    @php
                        $otherProofs = $selectedUser->paymentProofs->where('status', '!=', $selectedProof?->status ?? 'pending');
                    @endphp
                    @if($otherProofs->count() > 0 && $selectedProof->status === 'pending')
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <h5 class="font-semibold mb-3 text-lg text-slate-900">ข้อมูลการแก้ไข</h5>
                            <p class="text-sm text-slate-600 mb-4">ผู้ใช้ได้ส่งข้อมูลแก้ไขใหม่หลังจากถูกปฏิเสธ เปรียบเทียบการเปลี่ยนแปลงด้านล่าง:</p>
                            
                            <div class="space-y-3">
                                @foreach($otherProofs as $oldProof)
                                    <div class="bg-white rounded-lg p-3 border border-slate-200">
                                        <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Payment Slip เก่า (สถานะ: {{ ucfirst($oldProof->status) }})</p>
                                        <div class="border border-slate-200 rounded-lg p-3 bg-slate-50 overflow-hidden">
                                            <img src="{{ $oldProof->proof_file_url }}"
                                                 alt="Old Payment Slip"
                                                 class="w-full max-h-[300px] object-contain rounded shadow-sm">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Admin Note (if already reviewed) -->
                    @if($selectedProof && $selectedProof->admin_note)
                        <div class="mb-6">
                            <h5 class="font-semibold mb-2">Previous Admin Note</h5>
                            <div class="bg-slate-100 border border-slate-300 rounded p-3 text-sm">
                                {{ $selectedProof->admin_note }}
                            </div>
                        </div>
                    @endif

                    <!-- Admin Note Input (for pending only) -->
                    @if($selectedProof && $selectedProof->status === 'pending')
                        <div class="mb-6">
                            <label class="block font-semibold mb-2">เหตุผล/หมายเหตุจากแอดมิน</label>
                            <textarea wire:model="adminNote"
                                      rows="3"
                                      class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="กรอกเหตุผล (จำเป็นเมื่อไม่อนุมัติ)"></textarea>
                            @error('adminNote')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 pb-4 sticky bottom-0 bg-white border-t border-slate-200 -mx-6 px-6 -mb-5">
                            <button wire:click="closeUserDetail"
                                    class="px-6 py-3 border border-slate-300 rounded-xl hover:bg-slate-50 font-medium transition-colors">
                                ยกเลิก
                            </button>

                            <button wire:click="rejectUser"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-60 cursor-not-allowed"
                                    wire:target="rejectUser"
                                    class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium flex items-center justify-center gap-2 shadow-sm transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span wire:loading.remove wire:target="rejectUser">ไม่อนุมัติ</span>
                                <span wire:loading wire:target="rejectUser">กำลังบันทึก...</span>
                            </button>

                            <button wire:click="approveUser"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-60 cursor-not-allowed"
                                    wire:target="approveUser"
                                    class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium flex items-center justify-center gap-2 shadow-sm transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span wire:loading.remove wire:target="approveUser">อนุมัติ</span>
                                <span wire:loading wire:target="approveUser">กำลังอนุมัติ...</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
