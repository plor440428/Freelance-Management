<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold">Projects</h3>
            <p class="text-sm text-slate-600">Manage your projects and tasks.</p>
        </div>
        @if(auth()->user()->role !== 'customer')
            <button wire:click="$set('showCreateModal', true)" class="px-3 py-2 bg-black text-white rounded">
                + New Project
            </button>
        @endif
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name</label>
                <input type="text" wire:model.live="search" placeholder="Search..." class="w-full border px-3 py-2 rounded text-sm" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="w-full border px-3 py-2 rounded text-sm">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="on_hold">On Hold</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <!-- Freelancer Multi-Select -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Freelancers</label>
                <button wire:click="toggleFreelanceDropdown"
                        type="button"
                        class="w-full border px-3 py-2 rounded text-sm text-left flex items-center justify-between hover:bg-slate-50">
                    <span class="text-gray-600">
                        @if(empty($filterFreelance))
                            All Freelancers
                        @else
                            {{ count($filterFreelance) }} selected
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                @if($showFreelanceDropdown)
                    <div class="absolute top-full left-0 right-0 mt-1 bg-white border rounded shadow-lg z-20 max-h-64 overflow-hidden flex flex-col">
                        <input type="text"
                               wire:model.live="freelanceSearch"
                               placeholder="Search freelancers..."
                               class="border-b px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        <div class="overflow-y-auto max-h-48 divide-y">
                            @forelse($filteredFreelancers as $freelancer)
                                <label class="flex items-center gap-2 px-3 py-2 hover:bg-slate-50 cursor-pointer">
                                    <input type="checkbox"
                                           wire:change="toggleFreelanceFilter({{ $freelancer->id }})"
                                           @checked(in_array($freelancer->id, $filterFreelance))
                                           class="rounded" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $freelancer->name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ $freelancer->email }}</p>
                                    </div>
                                </label>
                            @empty
                                <div class="px-3 py-4 text-sm text-slate-500 text-center">
                                    No freelancers found
                                </div>
                            @endforelse
                        </div>
                        <div class="border-t p-2 flex justify-end gap-2 bg-slate-50">
                            <button wire:click="toggleFreelanceDropdown"
                                    type="button"
                                    class="px-2 py-1 text-xs border rounded hover:bg-slate-100">
                                Close
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Customer Multi-Select -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Customers</label>
                <button wire:click="toggleCustomerDropdown"
                        type="button"
                        class="w-full border px-3 py-2 rounded text-sm text-left flex items-center justify-between hover:bg-slate-50">
                    <span class="text-gray-600">
                        @if(empty($filterCustomer))
                            All Customers
                        @else
                            {{ count($filterCustomer) }} selected
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                @if($showCustomerDropdown)
                    <div class="absolute top-full left-0 right-0 mt-1 bg-white border rounded shadow-lg z-20 max-h-64 overflow-hidden flex flex-col">
                        <input type="text"
                               wire:model.live="customerSearch"
                               placeholder="Search customers..."
                               class="border-b px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        <div class="overflow-y-auto max-h-48 divide-y">
                            @forelse($filteredCustomers as $customer)
                                <label class="flex items-center gap-2 px-3 py-2 hover:bg-slate-50 cursor-pointer">
                                    <input type="checkbox"
                                           wire:change="toggleCustomerFilter({{ $customer->id }})"
                                           @checked(in_array($customer->id, $filterCustomer))
                                           class="rounded" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $customer->name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
                                    </div>
                                </label>
                            @empty
                                <div class="px-3 py-4 text-sm text-slate-500 text-center">
                                    No customers found
                                </div>
                            @endforelse
                        </div>
                        <div class="border-t p-2 flex justify-end gap-2 bg-slate-50">
                            <button wire:click="toggleCustomerDropdown"
                                    type="button"
                                    class="px-2 py-1 text-xs border rounded hover:bg-slate-100">
                                Close
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Clear Filters Button -->
            <div class="flex items-end gap-2">
                @if($hasActiveFilters)
                    <button wire:click="clearFilters" class="w-full px-3 py-2 bg-slate-200 hover:bg-slate-300 text-sm rounded font-medium transition">
                        Clear Filters
                    </button>
                @else
                    <div class="text-sm text-slate-600">
                        Showing <strong>{{ $projects->count() }}</strong> of <strong>{{ $projects->total() }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        @forelse($projects as $project)
            <a wire:navigate href="/dashboard/projects/{{ $project->id }}" class="bg-white rounded shadow hover:shadow-lg transition p-4 cursor-pointer block">
                <!-- Project Header -->
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-900">{{ $project->name }}</h4>
                        <p class="text-xs text-slate-500 mt-1">
                            by
                            @if($project->freelance)
                                <span class="font-medium text-blue-600">{{ $project->freelance->name }}</span>
                            @else
                                {{ $project->creator->name }}
                            @endif
                        </p>
                    </div>
                    <span class="px-2 py-1 bg-slate-100 rounded text-xs font-medium
                        @if($project->status === 'active') bg-green-100 text-green-800
                        @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                        @else bg-blue-100 text-blue-800
                        @endif">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>

                <!-- Description -->
                @if($project->description)
                    <p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $project->description }}</p>
                @endif

                <!-- Customers -->
                @if($project->customers->count() > 0)
                    <div class="mb-3">
                        <p class="text-xs font-medium text-slate-600 mb-2">Customers:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->customers as $customer)
                                <span class="px-2 py-1 bg-blue-50 border border-blue-200 rounded text-xs">
                                    {{ $customer->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Task Count -->
                <div class="py-3 border-t border-slate-200">
                    <p class="text-sm text-slate-700">
                        <strong>{{ $project->tasks->count() }}</strong> tasks
                        <span class="text-xs text-slate-500">({{ $project->tasks->where('status', 'completed')->count() }} completed)</span>
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>No projects found. Create one to get started!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $projects->links() }}
    </div>

    <!-- Create Project Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showCreateModal', false)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Create Project</h3>
                    <button wire:click="$set('showCreateModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="createProject" class="space-y-4">
                        <!-- Project Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model.defer="description" rows="3" class="mt-1 block w-full border px-3 py-2 rounded"></textarea>
                            @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model.defer="status" class="mt-1 block w-full border px-3 py-2 rounded">
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customers -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Customers (Optional)</label>
                            <div class="flex gap-2 mb-2">
                                <input type="text" wire:model.defer="customerSearchQuery" placeholder="Search by email or name..." class="flex-1 border px-3 py-2 rounded text-sm" />
                                <button type="button" wire:click="searchCustomers" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">Search</button>
                            </div>
                            <div class="mt-2 space-y-2 border rounded p-3 max-h-48 overflow-y-auto">
                                @forelse($customers as $customer)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-2 rounded">
                                        <input type="checkbox" wire:model.defer="selectedCustomers" value="{{ $customer->id }}" class="rounded" />
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-6 h-6 rounded-full" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-400 text-center py-4">No customers found</p>
                                @endforelse
                            </div>
                            @error('selectedCustomers') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2 bg-black text-white rounded hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="createProject">Create</span>
                                <span wire:loading wire:target="createProject" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Creating...
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showCreateModal', false)" class="flex-1 px-4 py-2 border rounded">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
