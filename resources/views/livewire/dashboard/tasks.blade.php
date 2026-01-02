<div class="space-y-6">
    <!-- Header with Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold">My Tasks</h3>
            <p class="text-sm text-slate-600">Tasks assigned to you or created by you</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <!-- Search -->
            <input type="text" wire:model.live="searchTerm" placeholder="Search tasks..." class="px-3 py-2 border rounded-lg text-sm w-48">

            <!-- Status Filter -->
            <select wire:model.live="filterStatus" class="px-3 py-2 border rounded-lg text-sm">
                <option value="all">All Status</option>
                <option value="todo">Todo</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <!-- Priority Filter -->
            <select wire:model.live="filterPriority" class="px-3 py-2 border rounded-lg text-sm">
                <option value="all">All Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
    </div>

    <!-- Task Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-slate-800">{{ $tasks->count() }}</div>
            <div class="text-sm text-slate-500">Total Tasks</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-yellow-800">{{ $tasks->where('status', 'todo')->count() }}</div>
            <div class="text-sm text-yellow-600">Todo</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-blue-800">{{ $tasks->where('status', 'in_progress')->count() }}</div>
            <div class="text-sm text-blue-600">In Progress</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-800">{{ $tasks->where('status', 'completed')->count() }}</div>
            <div class="text-sm text-green-600">Completed</div>
        </div>
    </div>

    <!-- Project Accordion List -->
    <div class="space-y-3">
        @if($projectGroups->count() > 0)
            @foreach($projectGroups as $projectId => $group)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Accordion Header -->
                    <div class="p-4 cursor-pointer hover:bg-slate-50 transition" wire:click="toggleAccordion({{ $projectId }})">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Toggle Icon -->
                                <svg class="w-5 h-5 text-slate-400 transition-transform {{ in_array($projectId, $openAccordions) ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="font-semibold text-slate-900 truncate">{{ $group['project']->name }}</h4>
                                        <button wire:click.stop="viewProject({{ $projectId }})" class="px-2 py-1 text-xs bg-slate-100 hover:bg-slate-200 rounded">
                                            View Details
                                        </button>
                                    </div>
                                    <p class="text-sm text-slate-600">
                                        Owner: {{ $group['project']->creator->name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Task Stats -->
                            <div class="flex items-center gap-3 text-sm shrink-0">
                                <div class="text-center">
                                    <div class="font-bold text-slate-800">{{ $group['stats']['total'] }}</div>
                                    <div class="text-xs text-slate-500">Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-yellow-600">{{ $group['stats']['todo'] }}</div>
                                    <div class="text-xs text-yellow-600">Todo</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-blue-600">{{ $group['stats']['in_progress'] }}</div>
                                    <div class="text-xs text-blue-600">In Progress</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-green-600">{{ $group['stats']['completed'] }}</div>
                                    <div class="text-xs text-green-600">Done</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    @if(in_array($projectId, $openAccordions))
                        <div class="border-t divide-y bg-slate-50">
                            @foreach($group['tasks'] as $task)
                                <div class="p-4 hover:bg-white transition cursor-pointer" wire:click="viewTask({{ $task->id }})">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h5 class="font-medium text-slate-900">{{ $task->title }}</h5>

                                                <!-- Status Badge -->
                                                <span class="px-2 py-0.5 rounded text-xs font-medium
                                                    @if($task->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @else bg-slate-100 text-slate-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>

                                                <!-- Priority Badge -->
                                                <span class="px-2 py-0.5 rounded text-xs font-medium
                                                    @if($task->priority === 'high') bg-red-100 text-red-800
                                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-slate-100 text-slate-800
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>

                                            @if($task->description)
                                                <p class="text-sm text-slate-600 mb-2 line-clamp-1">{{ $task->description }}</p>
                                            @endif

                                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                                <!-- Assignee -->
                                                @if($task->assignee)
                                                    <div class="flex items-center gap-1">
                                                        <img src="{{ $task->assignee->profile_image_url }}" alt="{{ $task->assignee->name }}" class="w-4 h-4 rounded-full">
                                                        <span>{{ $task->assignee->name }}</span>
                                                    </div>
                                                @endif

                                                <!-- Due Date -->
                                                @if($task->due_date)
                                                    <div class="flex items-center gap-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600' : '' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>{{ $task->due_date->format('M d, Y') }}</span>
                                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                                            <span class="text-red-600 font-medium">Overdue</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Quick Status Update -->
                                        <div class="shrink-0" onclick="event.stopPropagation()">
                                            <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)"
                                                class="px-2 py-1 border rounded text-xs cursor-pointer">
                                                <option value="todo" @selected($task->status === 'todo')>Todo</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg font-medium text-slate-900 mb-1">No tasks found</h3>
                <p class="text-sm text-slate-500">You don't have any tasks yet.</p>
            </div>
        @endif
    </div>

    <!-- Task Detail Modal -->
    @if($showTaskDetail && $selectedTask)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="closeTaskDetail"></div>
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Task Details</h3>
                    <button wire:click="closeTaskDetail" class="text-slate-600 hover:text-slate-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $selectedTask->title }}</h2>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-lg text-sm font-medium
                                @if($selectedTask->status === 'completed') bg-green-100 text-green-800
                                @elseif($selectedTask->status === 'in_progress') bg-blue-100 text-blue-800
                                @else bg-slate-100 text-slate-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $selectedTask->status)) }}
                            </span>
                            <span class="px-3 py-1 rounded-lg text-sm font-medium
                                @if($selectedTask->priority === 'high') bg-red-100 text-red-800
                                @elseif($selectedTask->priority === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-slate-100 text-slate-800
                                @endif">
                                {{ ucfirst($selectedTask->priority) }} Priority
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($selectedTask->description)
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-2">Description</h4>
                            <p class="text-slate-700">{{ $selectedTask->description }}</p>
                        </div>
                    @endif

                    <!-- Task Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Project -->
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-2">Project</h4>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="font-medium">{{ $selectedTask->project->name }}</span>
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-2">Assigned To</h4>
                            @if($selectedTask->assignee)
                                <div class="flex items-center gap-2">
                                    <img src="{{ $selectedTask->assignee->profile_image_url }}" alt="{{ $selectedTask->assignee->name }}" class="w-8 h-8 rounded-full">
                                    <div>
                                        <p class="font-medium">{{ $selectedTask->assignee->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $selectedTask->assignee->email }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-slate-400">Unassigned</p>
                            @endif
                        </div>

                        <!-- Due Date -->
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-2">Due Date</h4>
                            @if($selectedTask->due_date)
                                <div class="flex items-center gap-2 {{ $selectedTask->due_date->isPast() && $selectedTask->status !== 'completed' ? 'text-red-600' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium">{{ $selectedTask->due_date->format('M d, Y') }}</span>
                                    @if($selectedTask->due_date->isPast() && $selectedTask->status !== 'completed')
                                        <span class="text-xs font-semibold">OVERDUE</span>
                                    @endif
                                </div>
                            @else
                                <p class="text-slate-400">No due date</p>
                            @endif
                        </div>

                        <!-- Created Date -->
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-2">Created</h4>
                            <p class="font-medium">{{ $selectedTask->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t">
                        <button wire:click="closeTaskDetail" class="w-full px-4 py-2 border rounded-lg hover:bg-slate-50">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Project Detail Modal -->
    @if($showProjectDetail && $selectedProject)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="closeProjectDetail"></div>
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Project Details</h3>
                    <button wire:click="closeProjectDetail" class="text-slate-600 hover:text-slate-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 space-y-6">
                    <!-- Project Info -->
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $selectedProject->name }}</h2>
                        @if($selectedProject->description)
                            <p class="text-slate-600">{{ $selectedProject->description }}</p>
                        @endif
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Creator -->
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-2">Created By</h4>
                            <div class="flex items-center gap-2">
                                <img src="{{ $selectedProject->creator->profile_image_url }}" alt="{{ $selectedProject->creator->name }}" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="font-medium">{{ $selectedProject->creator->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $selectedProject->creator->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Freelance Owner -->
                        @if($selectedProject->freelance)
                            <div>
                                <h4 class="text-sm font-medium text-slate-500 mb-2">Freelance Owner</h4>
                                <div class="flex items-center gap-2">
                                    <img src="{{ $selectedProject->freelance->profile_image_url }}" alt="{{ $selectedProject->freelance->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium">{{ $selectedProject->freelance->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $selectedProject->freelance->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Project Managers -->
                    @if($selectedProject->managers->count() > 0)
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-3">Project Managers</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->managers as $manager)
                                    <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg">
                                        <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-8 h-8 rounded-full">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-sm truncate">{{ $manager->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $manager->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Customers -->
                    @if($selectedProject->customers->count() > 0)
                        <div>
                            <h4 class="text-sm font-medium text-slate-500 mb-3">Customers</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->customers as $customer)
                                    <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg">
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-sm truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t">
                        @php
                            $user = auth()->user();
                            $canManageProject = $user->role === 'admin' 
                                || $selectedProject->created_by === $user->id 
                                || $selectedProject->freelance_id === $user->id
                                || $selectedProject->managers->contains($user->id);
                        @endphp
                        
                        @if($canManageProject && ($user->role === 'admin' || $selectedProject->created_by === $user->id || $selectedProject->freelance_id === $user->id))
                            <a href="{{ route('dashboard.projects.detail', $selectedProject->id) }}"
                               class="flex-1 px-4 py-2 bg-black text-white rounded-lg text-center hover:bg-slate-800">
                                Go to Project
                            </a>
                            <button wire:click="closeProjectDetail" class="flex-1 px-4 py-2 border rounded-lg hover:bg-slate-50">
                                Close
                            </button>
                        @else
                            <button wire:click="closeProjectDetail" class="w-full px-4 py-2 border rounded-lg hover:bg-slate-50">
                                Close
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
