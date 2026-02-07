<div>
    <h3 class="text-2xl font-bold mb-6">User Approvals</h3>

    <!-- Filter Tabs -->
    <div class="mb-6">
        <div class="flex space-x-2 border-b border-slate-200">
            <button wire:click="$set('filterStatus', 'pending')"
                    class="px-4 py-2 {{ $filterStatus === 'pending' ? 'border-b-2 border-blue-500 text-blue-600 font-semibold' : 'text-slate-600' }}">
                Pending
            </button>
            <button wire:click="$set('filterStatus', 'approved')"
                    class="px-4 py-2 {{ $filterStatus === 'approved' ? 'border-b-2 border-green-500 text-green-600 font-semibold' : 'text-slate-600' }}">
                Approved
            </button>
            <button wire:click="$set('filterStatus', 'rejected')"
                    class="px-4 py-2 {{ $filterStatus === 'rejected' ? 'border-b-2 border-red-500 text-red-600 font-semibold' : 'text-slate-600' }}">
                Rejected
            </button>
            <button wire:click="$set('filterStatus', 'all')"
                    class="px-4 py-2 {{ $filterStatus === 'all' ? 'border-b-2 border-slate-500 text-slate-600 font-semibold' : 'text-slate-600' }}">
                All
            </button>
        </div>
    </div>

    <!-- Pending Users List -->
    @if($filterStatus === 'pending' || $filterStatus === 'all')
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
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
                    <thead class="bg-slate-50">
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
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}"
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
    @if($filterStatus === 'approved' || $filterStatus === 'all')
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
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
                    <thead class="bg-slate-50">
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
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}"
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
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <h4 class="font-semibold text-lg">Rejected Users ({{ $rejectedUsers->total() }})</h4>
            </div>

            @if($rejectedUsers->isEmpty())
                <div class="p-8 text-center text-slate-500">
                    <p>No rejected users</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-slate-50">
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
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}"
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
                                    <span title="{{ $proof?->admin_note ?? '-' }}" class="truncate block">
                                        {{ $proof?->admin_note ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $proof?->approved_at?->format('M d, Y H:i') ?? '-' }}
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

    <!-- All Users List -->
    @if($filterStatus === 'all' && $users->isNotEmpty())
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-slate-200">
                <h4 class="font-semibold text-lg">All Users ({{ $users->total() }})</h4>
            </div>

            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($users as $user)
                        @php
                            $proof = $user->paymentProofs->first();
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                                             class="w-8 h-8 rounded-full mr-2" alt="{{ $user->name }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-400 flex items-center justify-center text-white text-xs font-semibold mr-2">
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
                                @if($user->is_approved)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Approved</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                @if(!$user->is_approved)
                                    <button wire:click="viewUser({{ $user->id }})"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Review
                                    </button>
                                @else
                                    <span class="text-slate-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        </div>
    @endif

    <!-- User Detail Modal -->
    @if($showUserDetail && $selectedUser)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeUserDetail">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-auto m-4" wire:click.stop>
                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-xl font-bold">Review Registration</h3>
                    <button wire:click="closeUserDetail" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <!-- User Info -->
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            @if($selectedUser->profile_image)
                                <img src="{{ asset('storage/' . $selectedUser->profile_image) }}"
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
                            <h5 class="font-semibold mb-3 text-lg">Payment Slip</h5>
                            <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                                <img src="{{ $selectedProof->proof_file_url }}"
                                     alt="Payment Slip"
                                     class="max-w-full h-auto rounded shadow-lg">
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
                            <label class="block font-semibold mb-2">Admin Note (Optional)</label>
                            <textarea wire:model="adminNote"
                                      rows="3"
                                      class="w-full border border-slate-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Add a note for this approval/rejection..."></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button wire:click="closeUserDetail"
                                    class="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                                Cancel
                            </button>

                            <!-- Reject Dropdown -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                        type="button"
                                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium flex items-center space-x-2">
                                    <span>ไม่อนุมัติ</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 bottom-full mb-2 w-64 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-10"
                                     style="display: none;">
                                    <button wire:click="rejectAndDelete"
                                            @click="open = false"
                                            class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-700 flex items-start space-x-2">
                                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <div>
                                            <div class="font-semibold">ไม่อนุมัติและลบบัญชี</div>
                                            <div class="text-xs text-slate-500">ลบบัญชีนี้ออกจากระบบถาวร</div>
                                        </div>
                                    </button>
                                    <button wire:click="rejectAndRequestRevision"
                                            @click="open = false"
                                            class="w-full text-left px-4 py-3 hover:bg-yellow-50 text-yellow-700 flex items-start space-x-2">
                                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <div>
                                            <div class="font-semibold">ไม่อนุมัติและส่งให้แก้ไข</div>
                                            <div class="text-xs text-slate-500">ส่งอีเมลให้ผู้ใช้แก้ไขข้อมูล</div>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <button wire:click="approveUser"
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>อนุมัติ</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
