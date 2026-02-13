<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-4xl font-black text-gray-900">My Tasks</h3>
            <p class="text-sm font-medium text-gray-600 mt-1">Tasks assigned to you or created by you</p>
        </div>
        <div class="text-sm font-medium text-gray-500">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <!-- Task Stats with Gradient Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-2">Total Tasks</p>
                    <p class="text-5xl font-black text-blue-600">{{ $tasks->count() }}</p>
                </div>
                <div class="p-4 bg-blue-100/50 group-hover:bg-blue-100 rounded-full transition">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Todo Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-2">To Do</p>
                    <p class="text-5xl font-black text-amber-500">{{ $tasks->where('status', 'todo')->count() }}</p>
                </div>
                <div class="p-4 bg-amber-100/50 group-hover:bg-amber-100 rounded-full transition">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- In Progress Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-2">In Progress</p>
                    <p class="text-5xl font-black text-purple-600">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="p-4 bg-purple-100/50 group-hover:bg-purple-100 rounded-full transition">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-2">Completed</p>
                    <p class="text-5xl font-black text-emerald-500">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
                <div class="p-4 bg-emerald-100/50 group-hover:bg-emerald-100 rounded-full transition">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Search</label>
                <input type="text" wire:model.live="searchTerm" placeholder="Search tasks..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                    <option value="all">All Status</option>
                    <option value="todo">To Do</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Priority</label>
                <select wire:model.live="filterPriority" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                    <option value="all">All Priority</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Project Accordion List -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-black text-gray-900">Projects with Tasks</h4>
            <p class="text-sm font-medium text-gray-500">
                Showing <strong>{{ $projectGroups->count() }}</strong> project(s)
            </p>
        </div>

        @if($projectGroups->count() > 0)
            @foreach($projectGroups as $projectId => $group)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <!-- Accordion Header -->
                    <div class="p-6 cursor-pointer hover:bg-gray-50 transition" wire:click="toggleAccordion({{ $projectId }})">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Toggle Icon -->
                                <svg class="w-5 h-5 text-gray-400 transition-transform {{ in_array($projectId, $openAccordions) ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                        <h4 class="font-black text-gray-900 truncate">{{ $group['project']->name }}</h4>
                                        <button wire:click.stop="viewProject({{ $projectId }})" class="px-3 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg font-semibold transition">
                                            View
                                        </button>
                                    </div>
                                    <p class="text-xs font-medium text-gray-600 ml-7">
                                        by <span class="text-gray-900 font-semibold">{{ $group['project']->creator->name }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Task Stats -->
                            <div class="flex items-center gap-5 text-sm shrink-0">
                                <div class="text-center">
                                    <div class="font-black text-gray-900 text-lg">{{ $group['stats']['total'] }}</div>
                                    <div class="text-xs font-medium text-gray-600">Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-black text-amber-600 text-lg">{{ $group['stats']['todo'] }}</div>
                                    <div class="text-xs font-medium text-amber-600">Todo</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-black text-purple-600 text-lg">{{ $group['stats']['in_progress'] }}</div>
                                    <div class="text-xs font-medium text-purple-600">In Prog</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-black text-emerald-600 text-lg">{{ $group['stats']['completed'] }}</div>
                                    <div class="text-xs font-medium text-emerald-600">Done</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    @if(in_array($projectId, $openAccordions))
                        <div class="border-t bg-gradient-to-b from-gray-50 to-white">
                            <!-- Project Status Filter -->
                            <div class="p-5 border-b bg-white" onclick="event.stopPropagation()">
                                <div class="flex items-center gap-3">
                                    <label class="text-sm font-semibold text-gray-700">Filter:</label>
                                    <select wire:model.live="projectStatusFilters.{{ $projectId }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                        <option value="all">All Status</option>
                                        <option value="todo">To Do ({{ $group['stats']['todo'] }})</option>
                                        <option value="in_progress">In Progress ({{ $group['stats']['in_progress'] }})</option>
                                        <option value="completed">Completed ({{ $group['stats']['completed'] }})</option>
                                    </select>
                                    <span class="text-sm font-medium text-gray-600 ml-auto">
                                        Showing {{ $group['tasks']->count() }} of {{ $group['stats']['total'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Task List -->
                            <div class="divide-y">
                            @foreach($group['tasks'] as $task)
                                <div class="p-5 hover:bg-blue-50 transition cursor-pointer border-b border-gray-100 last:border-b-0" wire:click="viewTask({{ $task->id }})">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="flex-shrink-0">
                                                    @if($task->status === 'completed')
                                                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    @elseif($task->status === 'in_progress')
                                                        <svg class="w-5 h-5 text-purple-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <h5 class="font-semibold text-gray-900 truncate">{{ $task->title }}</h5>

                                                <!-- Status Badge -->
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold whitespace-nowrap
                                                    @if($task->status === 'completed') bg-emerald-100 text-emerald-700
                                                    @elseif($task->status === 'in_progress') bg-purple-100 text-purple-700
                                                    @else bg-gray-100 text-gray-700
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>

                                                <!-- Priority Badge -->
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold whitespace-nowrap
                                                    @if($task->priority === 'high') bg-red-100 text-red-700
                                                    @elseif($task->priority === 'medium') bg-amber-100 text-amber-700
                                                    @else bg-gray-100 text-gray-700
                                                    @endif">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </div>

                                            @if($task->description)
                                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $task->description }}</p>
                                            @endif

                                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                                <!-- Assignee -->
                                                @if($task->assignee)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ $task->assignee->profile_image_url }}" alt="{{ $task->assignee->name }}" class="w-5 h-5 rounded-full">
                                                        <span class="font-medium text-gray-700">{{ $task->assignee->name }}</span>
                                                    </div>
                                                @endif

                                                <!-- Due Date -->
                                                @if($task->due_date)
                                                    <div class="flex items-center gap-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 font-semibold' : '' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>{{ $task->due_date->format('M d') }}</span>
                                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                                            <span class="text-red-600 font-bold">⚠️</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Quick Status Update -->
                                        <div class="shrink-0" onclick="event.stopPropagation()">
                                            <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)"
                                                class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-semibold cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                                <option value="todo" @selected($task->status === 'todo')>To Do</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center hover:shadow-md transition">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xl font-black text-gray-900 mb-2">No tasks found</h3>
                <p class="text-gray-600 font-medium">You don't have any tasks yet.</p>
            </div>
        @endif
    </div>

    <!-- Task Detail Modal -->
    @if($showTaskDetail && $selectedTask)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" wire:click="closeTaskDetail"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto border border-gray-100">
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-50 to-white px-7 py-6 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Task Details</p>
                        <p class="text-2xl font-black text-gray-900 mt-1">{{ $selectedTask->title }}</p>
                    </div>
                    <button wire:click="closeTaskDetail" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-7 space-y-6">
                    <!-- Status & Priority -->
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3 py-1.5 rounded-lg text-sm font-semibold
                            @if($selectedTask->status === 'completed') bg-emerald-100 text-emerald-700
                            @elseif($selectedTask->status === 'in_progress') bg-purple-100 text-purple-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $selectedTask->status)) }}
                        </span>
                        <span class="px-3 py-1.5 rounded-lg text-sm font-semibold
                            @if($selectedTask->priority === 'high') bg-red-100 text-red-700
                            @elseif($selectedTask->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($selectedTask->priority) }} Priority
                        </span>
                    </div>

                    <!-- Description -->
                    @if($selectedTask->description)
                        <div>
                            <h4 class="font-black text-gray-900 mb-3 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Description
                            </h4>
                            <p class="text-gray-700 leading-relaxed font-medium">{{ $selectedTask->description }}</p>
                        </div>
                    @endif

                    <!-- Task Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        <!-- Project -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Project</h4>
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="font-semibold text-gray-900">{{ $selectedTask->project->name }}</span>
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Assigned To</h4>
                            @if($selectedTask->assignee)
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <img src="{{ $selectedTask->assignee->profile_image_url }}" alt="{{ $selectedTask->assignee->name }}" class="w-10 h-10 rounded-full flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">{{ $selectedTask->assignee->name }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ $selectedTask->assignee->email }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-gray-600 text-sm font-medium">Unassigned</div>
                            @endif
                        </div>

                        <!-- Due Date -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Due Date</h4>
                            @if($selectedTask->due_date)
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border {{ $selectedTask->due_date->isPast() && $selectedTask->status !== 'completed' ? 'border-red-300 ring-2 ring-red-200' : 'border-gray-100' }}">
                                    <svg class="w-5 h-5 flex-shrink-0 {{ $selectedTask->due_date->isPast() && $selectedTask->status !== 'completed' ? 'text-red-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $selectedTask->due_date->format('F d, Y') }}</p>
                                        @if($selectedTask->due_date->isPast() && $selectedTask->status !== 'completed')
                                            <p class="text-xs text-red-600 font-bold">OVERDUE</p>
                                        @else
                                            <p class="text-xs text-gray-600 font-medium">{{ $selectedTask->due_date->diffForHumans() }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-gray-600 text-sm font-medium">No due date</div>
                            @endif
                        </div>

                        <!-- Created Date -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Created</h4>
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <p class="font-semibold text-gray-900">{{ $selectedTask->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-gray-600 font-medium">{{ $selectedTask->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button wire:click="closeTaskDetail" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
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
            <div class="absolute inset-0 bg-black/50" wire:click="closeProjectDetail"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto border border-gray-100">
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-purple-50 to-white px-7 py-6 flex items-center justify-between border-b border-gray-100">
                    <div>
                        <p class="text-xs font-bold text-purple-600 uppercase tracking-widest">Project Details</p>
                        <p class="text-2xl font-black text-gray-900 mt-1">{{ $selectedProject->name }}</p>
                    </div>
                    <button wire:click="closeProjectDetail" class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-7 space-y-6">
                    <!-- Description -->
                    @if($selectedProject->description)
                        <div>
                            <h4 class="font-black text-gray-900 mb-3 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Description
                            </h4>
                            <p class="text-gray-700 leading-relaxed font-medium">{{ $selectedProject->description }}</p>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        <!-- Creator -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Created By</h4>
                            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <img src="{{ $selectedProject->creator->profile_image_url }}" alt="{{ $selectedProject->creator->name }}" class="w-12 h-12 rounded-full flex-shrink-0">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $selectedProject->creator->name }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $selectedProject->creator->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Freelance Owner -->
                        @if($selectedProject->freelance)
                            <div>
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-3">Freelance Owner</h4>
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <img src="{{ $selectedProject->freelance->profile_image_url }}" alt="{{ $selectedProject->freelance->name }}" class="w-12 h-12 rounded-full flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">{{ $selectedProject->freelance->name }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ $selectedProject->freelance->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-gray-600">
                                <p class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Freelance Owner</p>
                                <p class="font-medium">Not assigned</p>
                            </div>
                        @endif
                    </div>

                    <!-- Project Managers -->
                    @if($selectedProject->managers->count() > 0)
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Project Managers
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->managers as $manager)
                                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                        <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-10 h-10 rounded-full flex-shrink-0">
                                        <div class="min-w-0">
                                            <p class="font-semibold text-sm text-gray-900 truncate">{{ $manager->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $manager->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Customers -->
                    @if($selectedProject->customers->count() > 0)
                        <div>
                            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 20H9m8-4h.01M15 16h.01M9 20H5v-2a3 3 0 015.856-1.487M9 16H9.01" />
                                </svg>
                                Customers
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->customers as $customer)
                                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100">
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-10 h-10 rounded-full flex-shrink-0">
                                        <div class="min-w-0">
                                            <p class="font-semibold text-sm text-gray-900 truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        @php
                            $user = auth()->user();
                            $canManageProject = $user->role === 'admin'
                                || $selectedProject->created_by === $user->id
                                || $selectedProject->freelance_id === $user->id
                                || $selectedProject->managers->contains($user->id);
                        @endphp

                        @if($canManageProject && ($user->role === 'admin' || $selectedProject->created_by === $user->id || $selectedProject->freelance_id === $user->id))
                            <a href="{{ route('dashboard.projects.detail', $selectedProject->id) }}"
                               class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg text-center hover:bg-blue-700 font-semibold transition">
                                Go to Project
                            </a>
                        @endif
                        <button wire:click="closeProjectDetail" class="flex-1 px-4 py-3 border border-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
