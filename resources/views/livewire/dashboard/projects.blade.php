<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-white to-gray-50 border-b border-gray-200 px-6 py-8 mb-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="dash-title text-3xl font-bold text-gray-900">Projects</h3>
                </div>
                <p class="text-gray-600">Manage and track all your projects</p>
            </div>
            @if(auth()->user()->role !== 'customer')
                <button wire:click="$set('showCreateModal', true)" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 font-medium transition flex items-center gap-2 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Project
                </button>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <!-- Search & Filter Section -->
        <div class="dash-panel rounded-xl p-6 mb-8 border border-gray-200 relative z-30 overflow-visible">
            <div class="mb-4">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Filter Projects</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Name</label>
                    <div class="relative">
                        <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" wire:model.live="search" placeholder="Find project..." class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-500 px-3 py-2 pl-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="filterStatus" class="w-full bg-white border border-gray-300 text-gray-900 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="on_hold">On Hold</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Freelancer Multi-Select -->
                <div class="relative z-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Freelancers</label>
                    <button wire:click="toggleFreelanceDropdown"
                            type="button"
                            class="w-full bg-white border border-gray-300 text-gray-900 px-3 py-2 rounded-lg text-sm text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span>
                            @if(empty($filterFreelance))
                                All Freelancers
                            @else
                                {{ count($filterFreelance) }} selected
                            @endif
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    @if($showFreelanceDropdown)
                        <div class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-2xl z-[70] max-h-64 overflow-hidden flex flex-col">
                            <input type="text"
                                   wire:model.live="freelanceSearch"
                                   placeholder="Search freelancers..."
                                   class="bg-gray-50 border-b border-gray-200 text-gray-900 placeholder-gray-500 px-3 py-2 text-sm focus:outline-none" />
                            <div class="overflow-y-auto max-h-48 divide-y divide-gray-200">
                                @forelse($filteredFreelancers as $freelancer)
                                    <label class="flex items-center gap-2 px-3 py-2 hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox"
                                               wire:change="toggleFreelanceFilter({{ $freelancer->id }})"
                                               @checked(in_array($freelancer->id, $filterFreelance))
                                               class="rounded accent-blue-600" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $freelancer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $freelancer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <div class="px-3 py-4 text-sm text-gray-600 text-center">
                                        No freelancers found
                                    </div>
                                @endforelse
                            </div>
                            <div class="border-t border-gray-200 p-2 flex justify-end gap-2 bg-gray-50">
                                <button wire:click="toggleFreelanceDropdown"
                                        type="button"
                                        class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border border-gray-300">
                                    Close
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Customer Multi-Select -->
                <div class="relative z-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customers</label>
                    <button wire:click="toggleCustomerDropdown"
                            type="button"
                            class="w-full bg-white border border-gray-300 text-gray-900 px-3 py-2 rounded-lg text-sm text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span>
                            @if(empty($filterCustomer))
                                All Customers
                            @else
                                {{ count($filterCustomer) }} selected
                            @endif
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    @if($showCustomerDropdown)
                        <div class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-300 rounded-lg shadow-2xl z-[70] max-h-64 overflow-hidden flex flex-col">
                            <input type="text"
                                   wire:model.live="customerSearch"
                                   placeholder="Search customers..."
                                   class="bg-gray-50 border-b border-gray-200 text-gray-900 placeholder-gray-500 px-3 py-2 text-sm focus:outline-none" />
                            <div class="overflow-y-auto max-h-48 divide-y divide-gray-200">
                                @forelse($filteredCustomers as $customer)
                                    <label class="flex items-center gap-2 px-3 py-2 hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox"
                                               wire:change="toggleCustomerFilter({{ $customer->id }})"
                                               @checked(in_array($customer->id, $filterCustomer))
                                               class="rounded accent-blue-600" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <div class="px-3 py-4 text-sm text-gray-600 text-center">
                                        No customers found
                                    </div>
                                @endforelse
                            </div>
                            <div class="border-t border-gray-200 p-2 flex justify-end gap-2 bg-gray-50">
                                <button wire:click="toggleCustomerDropdown"
                                        type="button"
                                        class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border border-gray-300">
                                    Close
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Clear Filters Button -->
                <div class="flex items-end">
                    @if($hasActiveFilters)
                        <button wire:click="clearFilters" class="w-full px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded-lg font-medium transition border border-red-300">
                            Reset
                        </button>
                    @else
                        <div class="text-sm text-gray-600">
                            <strong class="text-gray-900">{{ $projects->count() }}</strong> of <strong class="text-gray-900">{{ $projects->total() }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="dash-grid relative z-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($projects as $project)
                <a wire:navigate href="/dashboard/projects/{{ $project->id }}" class="bg-white rounded-xl shadow hover:shadow-2xl hover:scale-105 transition p-6 cursor-pointer block border border-gray-200 hover:border-blue-500/50">
                    <!-- Project Status Badge -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 mb-1">{{ $project->name }}</h4>
                            <p class="text-xs text-gray-600">
                                by
                                @if($project->freelance)
                                    <span class="font-medium text-blue-600">{{ $project->freelance->name }}</span>
                                @else
                                    <span class="text-gray-700">{{ $project->creator->name }}</span>
                                @endif
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap ml-2
                            @if($project->status === 'active') bg-emerald-100 text-emerald-800 border border-emerald-300
                            @elseif($project->status === 'on_hold') bg-amber-100 text-amber-800 border border-amber-300
                            @elseif($project->status === 'cancelled') bg-red-100 text-red-700 border border-red-300
                            @else bg-blue-100 text-blue-800 border border-blue-300
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($project->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $project->description }}</p>
                    @else
                        <p class="text-sm text-gray-500 italic mb-4">No description</p>
                    @endif

                    <!-- Customers -->
                    @if($project->customers->count() > 0)
                        <div class="mb-4 pb-4 border-b border-gray-200">
                            <p class="text-xs font-semibold text-gray-700 mb-2 uppercase tracking-wide">Customers</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($project->customers->take(3) as $customer)
                                    <span class="px-2 py-1 bg-blue-100 border border-blue-300 rounded-lg text-xs text-blue-800 font-medium">
                                        {{ $customer->name }}
                                    </span>
                                @endforeach
                                @if($project->customers->count() > 3)
                                    <span class="px-2 py-1 bg-gray-100 border border-gray-300 rounded-lg text-xs text-gray-700 font-medium">
                                        +{{ $project->customers->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Stats Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-700">
                                <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h3a1 1 0 000-2h-2a2 2 0 00-2 2v1H4V5z" clip-rule="evenodd"></path>
                                </svg>
                                <strong class="text-gray-900">{{ $project->tasks->count() }}</strong> tasks
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="relative w-12 h-1 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $project->tasks->count() > 0 ? ($project->tasks->where('status', 'completed')->count() / $project->tasks->count() * 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ $project->tasks->where('status', 'completed')->count() }}/{{ $project->tasks->count() }} done
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-700 text-lg font-medium mb-2">No projects found</p>
                    <p class="text-gray-600 text-sm mb-6">Get started by creating your first project</p>
                    @if(auth()->user()->role !== 'customer')
                        <button wire:click="$set('showCreateModal', true)" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                            Create a Project
                        </button>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mb-8">
            <div class="flex justify-center">
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    <!-- Create Project Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="$set('showCreateModal', false)"></div>
            <div class="absolute right-0 top-0 h-screen max-h-screen w-full max-w-2xl bg-white/95 shadow-2xl ring-1 ring-slate-200 flex flex-col z-[1001]">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-white to-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Create New Project</h3>
                    </div>
                    <button wire:click="$set('showCreateModal', false)" class="text-gray-600 hover:text-gray-900 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <form wire:submit.prevent="createProject" class="space-y-5 h-full flex flex-col">
                        <!-- Project Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Project Name</label>
                            <input type="text" wire:model.defer="name" placeholder="Enter project name..." class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-500 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                            <textarea wire:model.defer="description" rows="3" placeholder="Describe your project..." class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-500 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"></textarea>
                            @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                            <select wire:model.defer="status" class="w-full bg-white border border-gray-300 text-gray-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Customers -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Customers (Optional)</label>
                            <div class="flex gap-2 mb-3">
                                <input type="text" wire:model.defer="customerSearchQuery" placeholder="Search by email or name..." class="flex-1 bg-white border border-gray-300 text-gray-900 placeholder-gray-500 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm" />
                                <button type="button" wire:click="searchCustomers" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">Search</button>
                            </div>
                            <div class="mt-2 space-y-2 border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto bg-gray-50">
                                @forelse($customers as $customer)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded-lg transition">
                                        <input type="checkbox" wire:model.defer="selectedCustomers" value="{{ $customer->id }}" class="rounded accent-blue-600" />
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full border border-gray-300" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-600 text-center py-6">No customers found</p>
                                @endforelse
                            </div>
                            @error('selectedCustomers') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="createProject" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create Project
                                </span>
                                <span wire:loading wire:target="createProject" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Creating...
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showCreateModal', false)" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg font-medium transition border border-gray-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
