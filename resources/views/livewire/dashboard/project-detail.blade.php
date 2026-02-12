<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <button onclick="window.history.back()" class="text-slate-600 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div>
                <h3 class="text-xl font-bold">{{ $project->name }}</h3>
                <p class="text-sm text-slate-500">
                    by
                    @if($project->freelance)
                        <span class="font-medium text-blue-600">{{ $project->freelance->name }}</span>
                    @else
                        {{ $project->creator->name }}
                    @endif
                    • {{ $project->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id() || $project->freelance_id === auth()->id())
                <select wire:change="updateStatus($event.target.value)"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium border-0 focus:ring-2 focus:ring-black cursor-pointer
                    @if($project->status === 'active') bg-green-100 text-green-800
                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                    @else bg-blue-100 text-blue-800
                    @endif">
                    <option value="active" @selected($project->status === 'active')>Active</option>
                    <option value="on_hold" @selected($project->status === 'on_hold')>On Hold</option>
                    <option value="completed" @selected($project->status === 'completed')>Completed</option>
                </select>
                <button wire:click="editProject" class="px-3 py-1.5 border border-slate-300 rounded-lg hover:bg-slate-50 text-sm">
                    Edit
                </button>
                @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id())
                    <button wire:click="confirmDelete" class="px-3 py-1.5 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 text-sm">
                        Delete
                    </button>
                @endif
            @else
                <span class="px-3 py-1.5 rounded-lg text-sm font-medium
                    @if($project->status === 'active') bg-green-100 text-green-800
                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                    @else bg-blue-100 text-blue-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-slate-900">{{ $project->tasks->count() }}</div>
            <div class="text-sm text-slate-500">Total Tasks</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-green-600">{{ $project->tasks->where('status', 'completed')->count() }}</div>
            <div class="text-sm text-slate-500">Completed</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-blue-600">{{ $project->tasks->where('status', 'in_progress')->count() }}</div>
            <div class="text-sm text-slate-500">In Progress</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-2xl font-bold text-slate-600">{{ $project->files->count() }}/5</div>
            <div class="text-sm text-slate-500">Files</div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (Tasks) -->
        <div class="lg:col-span-2 space-y-6">
            @if($project->description)
                <div class="bg-white rounded-lg shadow p-6">
                    <h4 class="font-semibold mb-2">Description</h4>
                    <p class="text-sm text-slate-700">{{ $project->description }}</p>
                </div>
            @endif

            <!-- Tasks Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 border-b">
                    <h4 class="font-semibold">Tasks</h4>
                    @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id() || $project->freelance_id === auth()->id())
                        <button wire:click="addNewTask" class="px-3 py-1.5 bg-black text-white rounded-lg text-sm hover:bg-slate-800">
                            + Add Task
                        </button>
                    @endif
                </div>

                <div class="divide-y max-h-[600px] overflow-y-auto">
                    <!-- New Task Form -->
                    @if($addingNewTask)
                        <div class="p-4 bg-blue-50 space-y-3">
                            <input type="text" wire:model.defer="tasks.0.title" placeholder="Task title..." class="w-full border px-3 py-2 rounded-lg text-sm" />
                            <textarea wire:model.defer="tasks.0.description" placeholder="Description (optional)..." rows="2" class="w-full border px-3 py-2 rounded-lg text-sm"></textarea>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                <select wire:model.defer="tasks.0.status" class="border px-2 py-1.5 rounded-lg text-sm">
                                    <option value="todo">Todo</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <select wire:model.defer="tasks.0.priority" class="border px-2 py-1.5 rounded-lg text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                <select wire:model.defer="tasks.0.assigned_to" class="border px-2 py-1.5 rounded-lg text-sm">
                                    <option value="">Unassigned</option>
                                    @foreach($taskAssignees as $assignee)
                                        <option value="{{ $assignee->id }}">{{ $assignee->name }}</option>
                                    @endforeach
                                </select>
                                <input type="date" wire:model.defer="tasks.0.due_date" class="border px-2 py-1.5 rounded-lg text-sm" />
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="saveNewTask(0)" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Save Task</button>
                                <button wire:click="cancelNewTask" class="px-4 py-2 border rounded-lg text-sm hover:bg-slate-50">Cancel</button>
                            </div>
                        </div>
                    @endif

                    <!-- Task List -->
                    @forelse($project->tasks as $task)
                        @if($editingTaskId === $task->id)
                            <!-- Edit Mode -->
                            <div class="p-4 bg-blue-50 space-y-3">
                                <input type="text" wire:model.defer="tasks.{{ $loop->index }}.title" value="{{ $task->title }}" placeholder="Task title..." class="w-full border px-3 py-2 rounded-lg text-sm" />
                                <textarea wire:model.defer="tasks.{{ $loop->index }}.description" placeholder="Description (optional)..." rows="2" class="w-full border px-3 py-2 rounded-lg text-sm">{{ $task->description }}</textarea>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <select wire:model.defer="tasks.{{ $loop->index }}.status" class="border px-2 py-1.5 rounded-lg text-sm">
                                        <option value="todo" @selected($task->status === 'todo')>Todo</option>
                                        <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                        <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                    </select>
                                    <select wire:model.defer="tasks.{{ $loop->index }}.priority" class="border px-2 py-1.5 rounded-lg text-sm">
                                        <option value="low" @selected($task->priority === 'low')>Low</option>
                                        <option value="medium" @selected($task->priority === 'medium')>Medium</option>
                                        <option value="high" @selected($task->priority === 'high')>High</option>
                                    </select>
                                    <select wire:model.defer="tasks.{{ $loop->index }}.assigned_to" class="border px-2 py-1.5 rounded-lg text-sm">
                                        <option value="">Unassigned</option>
                                        @foreach($taskAssignees as $assignee)
                                            <option value="{{ $assignee->id }}" @selected($task->assigned_to === $assignee->id)>{{ $assignee->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="date" wire:model.defer="tasks.{{ $loop->index }}.due_date" value="{{ $task->due_date?->format('Y-m-d') }}" class="border px-2 py-1.5 rounded-lg text-sm" />
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="saveTask({{ $task->id }})" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Save</button>
                                    <button wire:click="cancelEdit" class="px-4 py-2 border rounded-lg text-sm hover:bg-slate-50">Cancel</button>
                                </div>
                            </div>
                        @else
                            <!-- View Mode -->
                            <div class="p-4 hover:bg-slate-50 transition group">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-medium text-sm mb-1">{{ $task->title }}</h5>
                                        @if($task->description)
                                            <p class="text-xs text-slate-600 mb-2">{{ $task->description }}</p>
                                        @endif
                                        <div class="flex flex-wrap items-center gap-2">
                                            <select wire:change="updateTaskField({{ $task->id }}, 'status', $event.target.value)"
                                                class="px-2 py-1 rounded text-xs font-medium border-0 cursor-pointer
                                                @if($task->status === 'completed') bg-green-100 text-green-800
                                                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                                @else bg-slate-100 text-slate-800
                                                @endif">
                                                <option value="todo" @selected($task->status === 'todo')>Todo</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                            </select>
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($task->priority === 'high') bg-red-100 text-red-800
                                                @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-slate-100 text-slate-800
                                                @endif">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            @if($task->assignee)
                                                <div class="flex items-center gap-1.5 px-2 py-1 bg-slate-100 rounded">
                                                    <img src="{{ $task->assignee->profile_image_url }}" alt="{{ $task->assignee->name }}" class="w-4 h-4 rounded-full" />
                                                    <span class="text-xs">{{ $task->assignee->name }}</span>
                                                </div>
                                            @endif
                                            @if($task->due_date)
                                                <span class="text-xs text-slate-500">📅 {{ $task->due_date->format('M d') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(auth()->user()->role !== 'customer')
                                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <button wire:click="editTask({{ $task->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button wire:click="confirmDeleteTask({{ $task->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded">
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
                            <div class="p-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-sm">No tasks yet. Create one to get started!</p>
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
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-sm">Freelance Owner</h4>
                        <button wire:click="editFreelance" class="text-xs text-blue-600 hover:text-blue-800">
                            {{ $project->freelance ? 'Change' : 'Assign' }}
                        </button>
                    </div>
                    @if($project->freelance)
                        <div class="flex items-center gap-2">
                            <img src="{{ $project->freelance->profile_image_url }}" alt="{{ $project->freelance->name }}" class="w-10 h-10 rounded-full" />
                            <div class="min-w-0">
                                <p class="text-sm font-medium truncate">{{ $project->freelance->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $project->freelance->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg border border-dashed border-slate-300">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-xs text-slate-500">No freelance assigned</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Project Managers -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-sm">Project Managers</h4>
                    @if(auth()->user()->role !== 'customer')
                        <button wire:click="editManagers" class="text-xs text-blue-600 hover:text-blue-800">
                            {{ $project->managers->count() > 0 ? 'Edit' : 'Add' }}
                        </button>
                    @endif
                </div>
                @if($project->managers->count() > 0)
                    <div class="space-y-2">
                        @foreach($project->managers as $manager)
                            <div class="flex items-center gap-2">
                                <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-8 h-8 rounded-full" />
                                <div class="min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $manager->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $manager->email }} • {{ ucfirst($manager->role) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-400">No managers assigned</p>
                @endif
            </div>

            <!-- Customers -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-sm">Customers</h4>
                    @if(auth()->user()->role !== 'customer')
                        <button wire:click="editCustomers" class="text-xs text-blue-600 hover:text-blue-800">
                            Edit
                        </button>
                    @endif
                </div>
                @if($project->customers->count() > 0)
                    <div class="space-y-2">
                        @foreach($project->customers as $customer)
                            <div class="flex items-center gap-2">
                                <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full" />
                                <div class="min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $customer->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-400">No customers</p>
                @endif
            </div>

            <!-- Files -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-sm mb-3">Files ({{ $project->files->count() }}/5)</h4>

                @if(auth()->user()->role !== 'customer')
                    @if($project->files->count() < 5)
                        <label class="block mb-3">
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-slate-400 hover:bg-slate-50 transition cursor-pointer">
                                <input type="file" wire:model="uploadedFiles" multiple
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar"
                                    class="hidden" />
                                <svg class="w-8 h-8 mx-auto mb-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-xs font-medium text-slate-700">Click to upload</p>
                            </div>
                        </label>
                        <div wire:loading wire:target="uploadedFiles" class="text-xs text-blue-600 mb-2">Uploading...</div>
                        @error('uploadedFiles') <p class="text-xs text-red-600 mb-2">{{ $message }}</p> @enderror
                        @error('uploadedFiles.*') <p class="text-xs text-red-600 mb-2">{{ $message }}</p> @enderror
                    @endif
                @endif

                @if($project->files->count() > 0)
                    <div class="space-y-2">
                        @foreach($project->files as $file)
                            <div class="flex items-center justify-between p-2 border rounded hover:bg-slate-50 transition group">
                                <a href="{{ $file->url }}" target="_blank" class="flex items-center gap-2 flex-1 min-w-0">
                                    @if(in_array($file->file_type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <img src="{{ $file->url }}" alt="{{ $file->file_name }}" class="w-8 h-8 object-cover rounded" />
                                    @else
                                        <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center">
                                            <span class="text-xs font-bold text-slate-600">{{ strtoupper(substr($file->file_type, 0, 3)) }}</span>
                                        </div>
                                    @endif
                                    <p class="text-xs font-medium text-slate-900 truncate flex-1">{{ $file->file_name }}</p>
                                </a>
                                @if(auth()->user()->role !== 'customer')
                                    <button wire:click="confirmDeleteFile({{ $file->id }})"
                                        class="text-slate-400 hover:text-red-600 p-1 opacity-0 group-hover:opacity-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 text-center py-4">No files</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Project Details Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('showEditModal', false)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Edit Project Details</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateProject" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 block w-full border px-3 py-2 rounded" />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model.defer="description" rows="3" class="mt-1 block w-full border px-3 py-2 rounded"></textarea>
                            @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model.defer="status" class="mt-1 block w-full border px-3 py-2 rounded">
                                <option value="active">Active</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="flex-1 px-4 py-2 bg-black text-white rounded">Update</button>
                            <button type="button" wire:click="$set('showEditModal', false)" class="flex-1 px-4 py-2 border rounded">Cancel</button>
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
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Manage Customers</h3>
                    <button wire:click="$set('showEditCustomersModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateCustomers" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Customers</label>
                            <div class="space-y-2 border rounded p-3 max-h-64 overflow-y-auto">
                                @forelse($customers as $customer)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-2 rounded">
                                        <input type="checkbox" wire:model.defer="selectedCustomers" value="{{ $customer->id }}" class="rounded" />
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full" />
                                        <div class="flex-1">
                                            <p class="text-sm font-medium">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-500 text-center py-4">No customers available</p>
                                @endforelse
                            </div>
                            @error('selectedCustomers') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="flex-1 px-4 py-2 bg-black text-white rounded">Save Changes</button>
                            <button type="button" wire:click="$set('showEditCustomersModal', false)" class="flex-1 px-4 py-2 border rounded">Cancel</button>
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
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Manage Project Managers</h3>
                    <button wire:click="$set('showEditManagersModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>

                <div class="p-6 max-h-96 overflow-y-auto">
                    <form wire:submit.prevent="updateManagers" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Managers (Freelances Only)</label>
                            <div class="space-y-2 border rounded p-3 max-h-64 overflow-y-auto">
                                @forelse($availableManagers as $manager)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-2 rounded">
                                        <input type="checkbox" wire:model.defer="selectedManagers" value="{{ $manager->id }}" class="rounded" />
                                        <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-8 h-8 rounded-full" />
                                        <div class="flex-1">
                                            <p class="text-sm font-medium">{{ $manager->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $manager->email }} • {{ ucfirst($manager->role) }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-500 text-center py-4">No managers available</p>
                                @endforelse
                            </div>
                            @error('selectedManagers') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="flex-1 px-4 py-2 bg-black text-white rounded">Save Changes</button>
                            <button type="button" wire:click="$set('showEditManagersModal', false)" class="flex-1 px-4 py-2 border rounded">Cancel</button>
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
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Assign Freelance</h3>
                    <button wire:click="$set('showEditFreelanceModal', false)" class="text-slate-600 hover:text-slate-800">&times;</button>
                </div>

                <div class="p-6">
                    <form wire:submit.prevent="updateFreelance" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Freelance (Only 1)</label>
                            <div class="space-y-2 border rounded p-3 max-h-64 overflow-y-auto">
                                <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-2 rounded">
                                    <input type="radio" wire:model.defer="selectedFreelance" value="" class="rounded" />
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-slate-600">No Freelance</p>
                                        <p class="text-xs text-slate-400">Remove freelance assignment</p>
                                    </div>
                                </label>
                                @forelse($freelances as $freelance)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-2 rounded">
                                        <input type="radio" wire:model.defer="selectedFreelance" value="{{ $freelance->id }}" class="rounded" />
                                        <img src="{{ $freelance->profile_image_url }}" alt="{{ $freelance->name }}" class="w-8 h-8 rounded-full" />
                                        <div class="flex-1">
                                            <p class="text-sm font-medium">{{ $freelance->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $freelance->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-slate-500 text-center py-4">No freelances available</p>
                                @endforelse
                            </div>
                            @error('selectedFreelance') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="flex-1 px-4 py-2 bg-black text-white rounded">Save Changes</button>
                            <button type="button" wire:click="$set('showEditFreelanceModal', false)" class="flex-1 px-4 py-2 border rounded">Cancel</button>
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
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
                <div class="p-4">
                    <p class="text-sm text-red-800">Are you sure you want to delete this project? This will also delete all tasks. This cannot be undone.</p>
                    <div class="mt-3 flex gap-2">
                        <button wire:click="deleteProject" class="px-3 py-2 bg-red-600 text-white rounded">Yes, delete</button>
                        <button wire:click="$set('confirmingDeleteId', null)" class="px-3 py-2 border rounded">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Task Confirmation -->
    @if($confirmingDeleteTaskId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteTaskId', null)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
                <div class="p-4">
                    <p class="text-sm text-red-800">Are you sure you want to delete this task? This cannot be undone.</p>
                    <div class="mt-3 flex gap-2">
                        <button wire:click="deleteTask" class="px-3 py-2 bg-red-600 text-white rounded">Yes, delete</button>
                        <button wire:click="$set('confirmingDeleteTaskId', null)" class="px-3 py-2 border rounded">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif



    <!-- Delete File Confirmation -->
    @if($confirmingDeleteFileId)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black opacity-40" wire:click="$set('confirmingDeleteFileId', null)"></div>
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden">
                <div class="p-4">
                    <p class="text-sm text-red-800">Are you sure you want to delete this file? This cannot be undone.</p>
                    <div class="mt-3 flex gap-2">
                        <button wire:click="deleteFile" class="px-3 py-2 bg-red-600 text-white rounded">Yes, delete</button>
                        <button wire:click="$set('confirmingDeleteFileId', null)" class="px-3 py-2 border rounded">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
