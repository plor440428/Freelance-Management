<div class="p-6 max-w-7xl mx-auto">
    <!-- Header with Modern Design -->
    <div class="bg-gradient-to-r from-slate-50 via-white to-slate-50 rounded-xl shadow-sm p-7 mb-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <button onclick="window.history.back()" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="border-l border-gray-200 pl-5">
                    <h1 class="text-3xl font-black text-gray-900">{{ $project->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1.5 font-medium">
                        by
                        @if($project->freelance)
                            <span class="text-blue-600">{{ $project->freelance->name }}</span>
                        @else
                            <span>{{ $project->creator->name }}</span>
                        @endif
                        • {{ $project->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
            @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id() || $project->freelance_id === auth()->id())
                <div wire:loading wire:target="updateStatus" class="px-4 py-2 rounded-lg text-sm bg-gray-200 text-gray-700 font-medium">
                    <svg class="animate-spin h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
                <select wire:change="updateStatus($event.target.value)" wire:loading.remove wire:target="updateStatus"
                    class="px-4 py-2 rounded-lg text-sm font-semibold border-2 focus:outline-none focus:ring-2 focus:ring-offset-2 cursor-pointer transition
                    @if($project->status === 'active') bg-emerald-50 text-emerald-700 border-emerald-300 focus:ring-emerald-400
                    @elseif($project->status === 'on_hold') bg-amber-50 text-amber-700 border-amber-300 focus:ring-amber-400
                    @else bg-blue-50 text-blue-700 border-blue-300 focus:ring-blue-400
                    @endif">
                    <option value="active" @selected($project->status === 'active')>Active</option>
                    <option value="on_hold" @selected($project->status === 'on_hold')>On Hold</option>
                    <option value="completed" @selected($project->status === 'completed')>Completed</option>
                </select>
                <button wire:click="editProject" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold disabled:opacity-50 transition flex items-center gap-2">
                    <span wire:loading.remove wire:target="editProject">Edit</span>
                    <span wire:loading wire:target="editProject" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </span>
                </button>
                @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id())
                    <button wire:click="confirmDelete" wire:loading.attr="disabled" class="px-4 py-2 border-2 border-red-300 text-red-600 rounded-lg hover:bg-red-50 text-sm font-semibold disabled:opacity-50 transition flex items-center gap-2">
                        <span wire:loading.remove wire:target="confirmDelete">Delete</span>
                        <span wire:loading wire:target="confirmDelete" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                        </span>
                    </button>
                @endif
            @else
                <span class="px-4 py-2 rounded-lg text-sm font-semibold border-2
                    @if($project->status === 'active') bg-emerald-50 text-emerald-700 border-emerald-300
                    @elseif($project->status === 'on_hold') bg-amber-50 text-amber-700 border-amber-300
                    @else bg-blue-50 text-blue-700 border-blue-300
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-blue-600 rounded-2xl p-6 hover:shadow-xl transition hover:scale-105 relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-5 transition"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div>
                    <p class="text-blue-100 text-xs font-bold tracking-widest mb-2">TOTAL TASKS</p>
                    <p class="text-5xl font-black text-white leading-none">{{ $project->tasks->count() }}</p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-24 h-24 bg-white bg-opacity-20 rounded-full -mr-8 -mt-8 group-hover:bg-opacity-30 transition"></div>
        </div>
        <div class="bg-emerald-500 rounded-2xl p-6 hover:shadow-xl transition hover:scale-105 relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-5 transition"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div>
                    <p class="text-emerald-100 text-xs font-bold tracking-widest mb-2">COMPLETED</p>
                    <p class="text-5xl font-black text-white leading-none">{{ $project->tasks->where('status', 'completed')->count() }}</p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-24 h-24 bg-white bg-opacity-20 rounded-full -mr-8 -mt-8 group-hover:bg-opacity-30 transition"></div>
        </div>
        <div class="bg-purple-600 rounded-2xl p-6 hover:shadow-xl transition hover:scale-105 relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-5 transition"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div>
                    <p class="text-purple-100 text-xs font-bold tracking-widest mb-2">IN PROGRESS</p>
                    <p class="text-5xl font-black text-white leading-none">{{ $project->tasks->where('status', 'in_progress')->count() }}</p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-24 h-24 bg-white bg-opacity-20 rounded-full -mr-8 -mt-8 group-hover:bg-opacity-30 transition"></div>
        </div>
        <div class="bg-amber-500 rounded-2xl p-6 hover:shadow-xl transition hover:scale-105 relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-5 transition"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div>
                    <p class="text-amber-100 text-xs font-bold tracking-widest mb-2">FILES</p>
                    <p class="text-5xl font-black text-white leading-none">{{ $project->files->count() }}<span class="text-2xl font-bold text-amber-100">/5</span></p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-24 h-24 bg-white bg-opacity-20 rounded-full -mr-8 -mt-8 group-hover:bg-opacity-30 transition"></div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Tasks) -->
        <div class="lg:col-span-2 space-y-6">
            @if($project->description)
                <div class="bg-white rounded-xl shadow-sm p-7 border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-6 bg-gradient-to-b from-blue-600 to-blue-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-lg">Description</h4>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-base">{{ $project->description }}</p>
                </div>
            @endif

            <!-- Tasks Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-6 bg-gradient-to-b from-blue-600 to-blue-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-lg">Tasks</h4>
                    </div>
                    @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id() || $project->freelance_id === auth()->id())
                        <button wire:click="addNewTask" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center gap-2">
                            <span wire:loading.remove wire:target="addNewTask">+ Add Task</span>
                            <span wire:loading wire:target="addNewTask" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </span>
                        </button>
                    @endif
                </div>

                <div class="divide-y max-h-[600px] overflow-y-auto">
                    <!-- New Task Form -->
                    @if($addingNewTask)
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-white space-y-4 border-b border-gray-100">
                            <div>
                                <label class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2 block">Task Title</label>
                                <input type="text" wire:model.defer="tasks.0.title" placeholder="Enter task title..." class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2 block">Description (Optional)</label>
                                <textarea wire:model.defer="tasks.0.description" placeholder="Add task description..." rows="2" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Status</label>
                                    <select wire:model.defer="tasks.0.status" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                        <option value="todo">Todo</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Priority</label>
                                    <select wire:model.defer="tasks.0.priority" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Assign To</label>
                                    <select wire:model.defer="tasks.0.assigned_to" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                        <option value="">Unassigned</option>
                                        @foreach($taskAssignees as $assignee)
                                            <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Due Date</label>
                                    <input type="date" wire:model.defer="tasks.0.due_date" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                </div>
                            </div>
                            <div class="flex gap-3 pt-2">
                                <button wire:click="saveNewTask(0)" wire:loading.attr="disabled" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="saveNewTask">Save Task</span>
                                    <span wire:loading wire:target="saveNewTask" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button wire:click="cancelNewTask" class="px-5 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                            </div>
                        </div>
                    @endif

                    <!-- Task List -->
                    @forelse($project->tasks as $task)
                        @if($editingTaskId === $task->id)
                            <!-- Edit Mode -->
                            <div class="p-6 bg-gradient-to-r from-blue-50 to-white space-y-4 border-b border-gray-100">
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2 block">Task Title</label>
                                    <input type="text" wire:model.defer="tasks.{{ $loop->index }}.title" value="{{ $task->title }}" placeholder="Enter task title..." class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-700 uppercase tracking-widest mb-2 block">Description (Optional)</label>
                                    <textarea wire:model.defer="tasks.{{ $loop->index }}.description" placeholder="Add task description..." rows="2" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ $task->description }}</textarea>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Status</label>
                                        <select wire:model.defer="tasks.{{ $loop->index }}.status" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                            <option value="todo" @selected($task->status === 'todo')>Todo</option>
                                            <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                            <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Priority</label>
                                        <select wire:model.defer="tasks.{{ $loop->index }}.priority" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                            <option value="low" @selected($task->priority === 'low')>Low</option>
                                            <option value="medium" @selected($task->priority === 'medium')>Medium</option>
                                            <option value="high" @selected($task->priority === 'high')>High</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Assign To</label>
                                        <select wire:model.defer="tasks.{{ $loop->index }}.assigned_to" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                            <option value="">Unassigned</option>
                                            @foreach($taskAssignees as $assignee)
                                                <option value="{{ $assignee->id }}" @selected($task->assigned_to === $assignee->id)>{{ $assignee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5 block">Due Date</label>
                                        <input type="date" wire:model.defer="tasks.{{ $loop->index }}.due_date" value="{{ $task->due_date?->format('Y-m-d') }}" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                    </div>
                                </div>
                                <div class="flex gap-3 pt-2">
                                    <button wire:click="saveTask({{ $task->id }})" wire:loading.attr="disabled" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                        <span wire:loading.remove wire:target="saveTask({{ $task->id }})">Save</span>
                                        <span wire:loading wire:target="saveTask({{ $task->id }})" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <button wire:click="cancelEdit" class="px-5 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                                </div>
                            </div>
                        @else
                            <!-- View Mode -->
                            <div class="p-5 hover:bg-blue-50 transition group border-b border-gray-100 last:border-b-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-sm text-gray-900 mb-2">{{ $task->title }}</h5>
                                        @if($task->description)
                                            <p class="text-sm text-gray-600 mb-3 leading-relaxed">{{ $task->description }}</p>
                                        @endif
                                        <div class="flex flex-wrap items-center gap-2">
                                            <select wire:change="updateTaskField({{ $task->id }}, 'status', $event.target.value)"
                                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border-0 cursor-pointer transition
                                                @if($task->status === 'completed') bg-green-100 text-green-700
                                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                <option value="todo" @selected($task->status === 'todo')>Todo</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                            </select>
                                            <span class="px-2.5 py-1.5 rounded-lg text-xs font-semibold
                                                @if($task->priority === 'high') bg-red-100 text-red-700
                                                @elseif($task->priority === 'medium') bg-amber-100 text-amber-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            @if($task->assignee)
                                                <div class="flex items-center gap-1.5 px-2.5 py-1.5 bg-gray-100 rounded-lg">
                                                    <img src="{{ $task->assignee->profile_image_url }}" alt="{{ $task->assignee->name }}" class="w-4 h-4 rounded-full" />
                                                    <span class="text-xs font-medium text-gray-700">{{ $task->assignee->name }}</span>
                                                </div>
                                            @endif
                                            @if($task->due_date)
                                                <span class="text-xs font-medium text-gray-600">📅 {{ $task->due_date->format('M d') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(auth()->user()->role !== 'customer')
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <button wire:click="editTask({{ $task->id }})" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmDeleteTask({{ $task->id }})" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @empty
                        @if(!$addingNewTask)
                            <div class="p-12 text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-sm font-medium text-gray-500">No tasks yet. Create one to get started!</p>
                            </div>
                        @endif
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Freelance (Admin Only) -->
            @if(auth()->user()->role === 'admin')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-4 bg-gradient-to-b from-blue-600 to-blue-400 rounded-full"></div>
                            <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Freelance Owner</h4>
                        </div>
                        <button wire:click="editFreelance" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ $project->freelance ? 'Change' : 'Assign' }}
                        </button>
                    </div>
                    @if($project->freelance)
                        <div class="flex items-center gap-3">
                            <img src="{{ $project->freelance->profile_image_url }}" alt="{{ $project->freelance->name }}" class="w-10 h-10 rounded-full" />
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $project->freelance->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $project->freelance->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-xs font-medium text-gray-600">No freelance assigned</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Project Managers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-gradient-to-b from-emerald-500 to-emerald-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Project Managers</h4>
                    </div>
                    @if(auth()->user()->role !== 'customer')
                        <button wire:click="editManagers" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ $project->managers->count() > 0 ? 'Edit' : 'Add' }}
                        </button>
                    @endif
                </div>
                @if($project->managers->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->managers as $manager)
                            <div class="flex items-center gap-3">
                                <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-8 h-8 rounded-full" />
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $manager->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $manager->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm font-medium text-gray-500">No managers assigned</p>
                @endif
            </div>

            <!-- Customers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-gradient-to-b from-purple-600 to-purple-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Customers</h4>
                    </div>
                    @if(auth()->user()->role !== 'customer')
                        <button wire:click="editCustomers" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            Edit
                        </button>
                    @endif
                </div>
                @if($project->customers->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->customers as $customer)
                            <div class="flex items-center gap-3">
                                <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full" />
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $customer->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm font-medium text-gray-500">No customers</p>
                @endif
            </div>

            <!-- Files -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-4 bg-gradient-to-b from-amber-500 to-amber-400 rounded-full"></div>
                    <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Files</h4>
                    <span class="text-xs font-semibold text-gray-500">({{ $project->files->count() }}/5)</span>
                </div>

                @if(auth()->user()->role !== 'customer')
                    @if($project->files->count() < 5)
                        <label class="block mb-4">
                            <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-blue-400 hover:bg-blue-50 transition cursor-pointer">
                                <input type="file" wire:model="uploadedFiles" multiple
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar"
                                    class="hidden" />
                                <svg class="w-8 h-8 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-xs font-semibold text-gray-600">Click to upload</p>
                            </div>
                        </label>
                        <div wire:loading wire:target="uploadedFiles" class="text-xs text-blue-600 mb-2 font-medium">Uploading...</div>
                        @error('uploadedFiles') <p class="text-xs text-red-600 mb-2 font-medium">{{ $message }}</p> @enderror
                        @error('uploadedFiles.*') <p class="text-xs text-red-600 mb-2 font-medium">{{ $message }}</p> @enderror
                    @endif
                @endif

                @if($project->files->count() > 0)
                    <div class="space-y-2">
                        @foreach($project->files as $file)
                            <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition group">
                                <a href="{{ $file->url }}" target="_blank" class="flex items-center gap-3 flex-1 min-w-0">
                                    @if(in_array($file->file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <img src="{{ $file->url }}" alt="{{ $file->file_name }}" class="w-7 h-7 object-cover rounded-lg" />
                                    @else
                                        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($file->file_type, 0, 3)) }}</span>
                                        </div>
                                    @endif
                                    <p class="text-xs font-semibold text-gray-900 truncate flex-1">{{ $file->file_name }}</p>
                                </a>
                                @if(auth()->user()->role !== 'customer')
                                    <button wire:click="confirmDeleteFile({{ $file->id }})"
                                        class="text-gray-300 hover:text-red-600 p-1 opacity-0 group-hover:opacity-100 transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs font-medium text-gray-500 text-center py-4">No files</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Project Details Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-100">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Edit Project Details</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateProject" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Project Name</label>
                            <input type="text" wire:model.defer="name" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            @error('name') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Description</label>
                            <textarea wire:model.defer="description" rows="3" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                            @error('description') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Status</label>
                            <select wire:model.defer="status" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer">
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="updateProject">Update</span>
                                <span wire:loading wire:target="updateProject" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showEditModal', false)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Customers Modal -->
    @if($showEditCustomersModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditCustomersModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-100">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Manage Customers</h3>
                    <button wire:click="$set('showEditCustomersModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateCustomers" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Customers</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="customerSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchCustomers" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                @forelse($customers as $customer)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition group">
                                        <input type="checkbox" wire:model.defer="selectedCustomers" value="{{ $customer->id }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm font-medium text-gray-500 text-center py-8">No customers found</p>
                                @endforelse
                            </div>
                            @error('selectedCustomers') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="updateCustomers">Save Changes</span>
                                <span wire:loading wire:target="updateCustomers" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showEditCustomersModal', false)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Managers Modal -->
    @if($showEditManagersModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditManagersModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden border border-gray-100">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Manage Project Managers</h3>
                    <button wire:click="$set('showEditManagersModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateManagers" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Managers (Freelances Only)</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="managerSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchManagers" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                @forelse($availableManagers as $manager)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition group">
                                        <input type="checkbox" wire:model.defer="selectedManagers" value="{{ $manager->id }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-8 h-8 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $manager->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $manager->email }} • {{ ucfirst($manager->role) }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-8">No managers found</p>
                                @endforelse
                            </div>
                            @error('selectedManagers') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="updateManagers">Save Changes</span>
                                <span wire:loading wire:target="updateManagers" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showEditManagersModal', false)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Freelance Modal -->
    @if($showEditFreelanceModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditFreelanceModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Assign Freelance</h3>
                    <button wire:click="$set('showEditFreelanceModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="p-6">
                    <form wire:submit.prevent="updateFreelance" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Freelance (Only 1)</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="freelanceSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchFreelance" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition">
                                    <input type="radio" wire:model.defer="selectedFreelance" value="" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">No Freelance</p>
                                        <p class="text-xs text-gray-600">Remove freelance assignment</p>
                                    </div>
                                </label>
                                @forelse($freelances as $freelance)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition">
                                        <input type="radio" wire:model.defer="selectedFreelance" value="{{ $freelance->id }}" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $freelance->profile_image_url }}" alt="{{ $freelance->name }}" class="w-8 h-8 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $freelance->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $freelance->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-8">No freelances found</p>
                                @endforelse
                            </div>
                            @error('selectedFreelance') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="updateFreelance">Save Changes</span>
                                <span wire:loading wire:target="updateFreelance" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showEditFreelanceModal', false)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Project Confirmation -->
    @if($confirmingDeleteId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Delete Project</h3>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-6">Are you sure you want to delete this project? This will also delete all tasks. This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button wire:click="deleteProject" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">Delete</button>
                        <button wire:click="$set('confirmingDeleteId', null)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Task Confirmation -->
    @if($confirmingDeleteTaskId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteTaskId', null)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Delete Task</h3>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-6">Are you sure you want to delete this task? This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button wire:click="deleteTask" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">Delete</button>
                        <button wire:click="$set('confirmingDeleteTaskId', null)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete File Confirmation -->
    @if($confirmingDeleteFileId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteFileId', null)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-900">Delete File</h3>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-6">Are you sure you want to delete this file? This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button wire:click="deleteFile" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition">Delete</button>
                        <button wire:click="$set('confirmingDeleteFileId', null)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
