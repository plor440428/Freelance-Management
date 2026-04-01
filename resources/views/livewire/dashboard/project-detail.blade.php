<div class="p-6 max-w-7xl mx-auto">
    <!-- Header with Modern Design -->
    <div class="bg-gradient-to-r from-slate-50 via-white to-slate-50 rounded-xl shadow-sm p-7 mb-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a wire:navigate href="{{ route('dashboard.projects') }}" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition inline-flex">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="border-l border-gray-200 pl-5">
                    <h1 class="dash-title text-3xl font-black text-gray-900">{{ $project->name }}</h1>
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
                    @elseif($project->status === 'cancelled') bg-red-50 text-red-700 border-red-300 focus:ring-red-400
                    @else bg-blue-50 text-blue-700 border-blue-300 focus:ring-blue-400
                    @endif">
                    <option value="active" @selected($project->status === 'active')>Active</option>
                    <option value="on_hold" @selected($project->status === 'on_hold')>On Hold</option>
                    <option value="completed" @selected($project->status === 'completed')>Completed</option>
                    <option value="cancelled" @selected($project->status === 'cancelled')>Cancelled</option>
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
                @if(auth()->user()->role === 'admin' || $project->created_by === auth()->id() || $project->freelance_id === auth()->id())
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
                    @elseif($project->status === 'cancelled') bg-red-50 text-red-700 border-red-300
                    @else bg-blue-50 text-blue-700 border-blue-300
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            @endif
        </div>
    </div>

    @if($project->status === 'cancelled' && $project->cancel_reason)
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">
            <div class="text-sm font-semibold mb-1">เหตุผลการยกเลิกโปรเจกต์</div>
            <div class="text-sm">{{ $project->cancel_reason }}</div>
        </div>
    @endif

    @if($project->total_price !== null)
        <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-1 h-5 bg-gradient-to-b from-emerald-500 to-emerald-300 rounded-full"></div>
                <h4 class="font-black text-gray-900">Project Pricing</h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Total Price</p>
                    <p class="text-lg font-black text-gray-900 mt-1">฿{{ number_format((float) $project->total_price, 2) }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Installments</p>
                    <p class="text-lg font-black text-gray-900 mt-1">{{ $project->installment_count }} งวด</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Due Day</p>
                    <p class="text-lg font-black text-gray-900 mt-1">ทุกวันที่ {{ $project->due_day_of_month }}</p>
                </div>
                <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-blue-600">Payment Progress</p>
                    <p class="text-sm font-black text-blue-800 mt-1">จ่ายแล้ว {{ $pricingProgress['paid_rounds'] }}/{{ $pricingProgress['planned_rounds'] }} งวด</p>
                    <p class="text-sm font-black text-indigo-800">คงเหลือ ฿{{ number_format((float) $pricingProgress['remaining_amount'], 2) }}</p>
                </div>
            </div>

            <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3">
                <div class="flex flex-wrap items-center justify-between gap-2 text-xs font-semibold text-emerald-800 mb-2">
                    <span>จ่ายแล้ว {{ $pricingProgress['paid_rounds'] }} งวด</span>
                    <span>เหลือ {{ $pricingProgress['remaining_rounds'] }} งวด</span>
                    <span>ตอนนี้ควรจ่ายแล้ว {{ $pricingProgress['due_now_rounds'] }} งวด</span>
                </div>
                <div class="w-full h-2 rounded-full bg-emerald-100 overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $pricingProgress['paid_percent'] }}%"></div>
                </div>
                <p class="text-[11px] text-emerald-700 mt-2">ความคืบหน้าการจ่าย {{ $pricingProgress['paid_percent'] }}%</p>
            </div>

            <div class="mt-4 rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-700">Installment Schedule</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-white text-gray-600 text-xs uppercase tracking-widest">
                            <tr>
                                <th class="px-4 py-2 text-left">งวด</th>
                                <th class="px-4 py-2 text-left">ครบกำหนด</th>
                                <th class="px-4 py-2 text-left">ยอดชำระ</th>
                                <th class="px-4 py-2 text-left">สถานะ</th>
                                <th class="px-4 py-2 text-left">เหตุผล/หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($installmentSchedule as $schedule)
                                <tr class="{{ $schedule['status'] === 'approved' ? 'bg-emerald-50/40' : ($schedule['is_due'] ? 'bg-amber-50/30' : 'bg-white') }}">
                                    <td class="px-4 py-2 font-semibold text-gray-900">{{ $schedule['round'] }}</td>
                                    <td class="px-4 py-2 text-gray-700">{{ $schedule['due_date']->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-gray-900 font-semibold">฿{{ number_format((float) $schedule['amount'], 2) }}</td>
                                    <td class="px-4 py-2">
                                        @if($schedule['status'] === 'approved')
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700">Approved</span>
                                        @elseif($schedule['status'] === 'pending')
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-700">Pending</span>
                                        @elseif($schedule['status'] === 'rejected')
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Rejected</span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-gray-600 text-xs">
                                        @if($schedule['payment'] && $schedule['payment']->review_note)
                                            {{ $schedule['payment']->review_note }}
                                        @elseif($schedule['payment'] && $schedule['payment']->note)
                                            {{ $schedule['payment']->note }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if($showCancelModal)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="closeCancelModal"></div>
            <div class="relative z-[1001] w-full max-w-lg max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-red-50">
                    <h3 class="text-lg font-black text-gray-900">ยืนยันการยกเลิกโปรเจกต์</h3>
                    <button wire:click="closeCancelModal" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Cancellation Reason</label>
                    <textarea wire:model.defer="cancelReason" rows="4" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none" placeholder="กรอกเหตุผลการยกเลิกโปรเจกต์..."></textarea>
                    @error('cancelReason') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                    <div class="flex gap-3 pt-5">
                        <button wire:click="confirmCancelStatus" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition">ยกเลิกโปรเจกต์</button>
                        <button type="button" wire:click="closeCancelModal" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">กลับ</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Bar -->
    <div class="dash-grid grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
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
                        <div wire:key="task-create-form" class="p-6 bg-gradient-to-r from-blue-50 to-white space-y-4 border-b border-gray-100">
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
                                <button type="button" wire:click.prevent="saveNewTask(0)" wire:loading.attr="disabled" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="saveNewTask">Save Task</span>
                                    <span wire:loading wire:target="saveNewTask" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" wire:click.prevent="cancelNewTask" class="px-5 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                            </div>
                        </div>
                    @endif

                    <!-- Task List -->
                    @forelse($project->tasks as $task)
                        @if($editingTaskId === $task->id)
                            <!-- Edit Mode -->
                            <div wire:key="task-edit-{{ $task->id }}" class="p-6 bg-gradient-to-r from-blue-50 to-white space-y-4 border-b border-gray-100">
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
                                    <button type="button" wire:click.prevent="saveTask({{ $task->id }})" wire:loading.attr="disabled" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                        <span wire:loading.remove wire:target="saveTask({{ $task->id }})">Save</span>
                                        <span wire:loading wire:target="saveTask({{ $task->id }})" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <button type="button" wire:click.prevent="cancelEdit" class="px-5 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                                </div>
                            </div>
                        @else
                            <!-- View Mode -->
                            <div wire:key="task-view-{{ $task->id }}" class="p-5 hover:bg-blue-50 transition group border-b border-gray-100 last:border-b-0">
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
                                            <button type="button" wire:click.prevent="editTask({{ $task->id }})" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button type="button" wire:click.prevent="confirmDeleteTask({{ $task->id }})" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition">
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
                        <button type="button" wire:click="toggleFreelanceSelector" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ $showFreelanceSelector ? 'Close' : ($project->freelance ? 'Edit' : 'Add') }}
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
                    @php
                        $creator = $project->creator;
                    @endphp
                    @if($creator && $creator->role === 'admin')
                        <div class="mt-3 p-2 bg-blue-50 border border-blue-100 rounded-lg flex items-start gap-2">
                            <span class="text-xs text-blue-600 font-semibold">Created by Admin</span>
                        </div>
                    @endif

                    @if($showFreelanceSelector)
                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Assign Freelance</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="freelanceSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            <button type="button" wire:click="searchFreelance" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                        </div>
                        <div class="space-y-1 border border-gray-200 rounded-lg p-3 max-h-52 overflow-y-auto bg-white">
                            @php($hasFreelanceSearch = trim((string) $freelanceSearchQuery) !== '')
                            @if(!$hasFreelanceSearch)
                                <p class="text-sm text-gray-500 text-center py-5">พิมพ์ค้นหา Freelance ก่อน</p>
                            @else
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-2 py-2 rounded-lg transition">
                                    <input type="radio" name="selected_freelance" wire:model.defer="selectedFreelance" value="" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">No Freelance</p>
                                    </div>
                                </label>
                                @forelse($freelances as $freelance)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-2 py-2 rounded-lg transition">
                                        <input type="radio" name="selected_freelance" wire:model.defer="selectedFreelance" value="{{ $freelance->id }}" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $freelance->profile_image_url }}" alt="{{ $freelance->name }}" class="w-7 h-7 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $freelance->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $freelance->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-5">No freelances found</p>
                                @endforelse
                            @endif
                        </div>
                        @error('selectedFreelance') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        <button type="button" wire:click="updateFreelance" wire:loading.attr="disabled" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-50">
                            Save Freelance Owner
                        </button>
                    </div>
                    @endif
                </div>
            @endif

            <!-- Team Members -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-gradient-to-b from-emerald-500 to-emerald-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Team Member</h4>
                    </div>
                    @if(auth()->user()->role !== 'customer')
                        <button type="button" wire:click="toggleTeamMemberSelector" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ $showTeamMemberSelector ? 'Close' : ($project->managers->count() ? 'Edit' : 'Add') }}
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
                    <p class="text-sm font-medium text-gray-500">No team members assigned</p>
                @endif

                @if(auth()->user()->role !== 'customer' && $showTeamMemberSelector)
                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Assign Team Members</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="teamMemberSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            <button type="button" wire:click="searchTeamMembers" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                        </div>
                        <div class="space-y-1 border border-gray-200 rounded-lg p-3 max-h-52 overflow-y-auto bg-white">
                            @php($hasTeamMemberSearch = trim((string) $teamMemberSearchQuery) !== '')
                            @if(!$hasTeamMemberSearch)
                                <p class="text-sm text-gray-500 text-center py-5">พิมพ์ค้นหา Team Member ก่อน</p>
                            @else
                                @forelse($availableTeamMembers as $member)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-2 py-2 rounded-lg transition group">
                                        <input type="checkbox" wire:model.defer="selectedTeamMembers" value="{{ $member->id }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $member->profile_image_url }}" alt="{{ $member->name }}" class="w-7 h-7 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $member->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $member->email }} • {{ ucfirst($member->role) }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-5">No team members found</p>
                                @endforelse
                            @endif
                        </div>
                        @error('selectedTeamMembers') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        @error('selectedTeamMembers.*') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        <button type="button" wire:click="updateTeamMembers" wire:loading.attr="disabled" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-50">
                            Save Team Members
                        </button>
                    </div>
                @endif
            </div>

            <!-- Customers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-gradient-to-b from-purple-600 to-purple-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Customer</h4>
                    </div>
                    @if(auth()->user()->role !== 'customer')
                        <button type="button" wire:click="toggleCustomerSelector" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">
                            {{ $showCustomerSelector ? 'Close' : ($project->customers->count() ? 'Edit' : 'Add') }}
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

                @if(auth()->user()->role !== 'customer' && $showCustomerSelector)
                    <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest">Assign Customer</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model.defer="customerSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            <button type="button" wire:click="searchCustomers" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                        </div>
                        <div class="space-y-1 border border-gray-200 rounded-lg p-3 max-h-52 overflow-y-auto bg-white">
                            @php($hasCustomerSearch = trim((string) $customerSearchQuery) !== '')
                            @if(!$hasCustomerSearch)
                                <p class="text-sm text-gray-500 text-center py-5">พิมพ์ค้นหา Customer ก่อน</p>
                            @else
                                <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-2 py-2 rounded-lg transition group">
                                    <input type="radio" name="selected_customer" wire:model.defer="selectedCustomer" value="" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">No Customer</p>
                                    </div>
                                </label>
                                @forelse($customers as $customer)
                                    <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-2 py-2 rounded-lg transition group">
                                        <input type="radio" name="selected_customer" wire:model.defer="selectedCustomer" value="{{ $customer->id }}" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-7 h-7 rounded-full flex-shrink-0" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm font-medium text-gray-500 text-center py-5">No customers found</p>
                                @endforelse
                            @endif
                        </div>
                        @error('selectedCustomer') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        <button type="button" wire:click="updateCustomers" wire:loading.attr="disabled" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition disabled:opacity-50">
                            Save Customer
                        </button>
                    </div>
                @endif
            </div>

            @if(in_array(auth()->user()->role, ['customer', 'freelance']))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-4 bg-gradient-to-b from-sky-600 to-sky-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Project Payment</h4>
                    </div>

                    @if(auth()->user()->role === 'customer')
                        <div class="mb-4 rounded-lg border border-sky-100 bg-sky-50 px-4 py-3 text-xs text-sky-800">
                            เมื่อส่งสลิปแล้ว รายการจะรอให้ฟรีแลนซ์ตรวจสอบยอดก่อนเปลี่ยนสถานะเป็นอนุมัติหรือไม่อนุมัติ
                        </div>

                        @if($project->total_price !== null)
                            @if(is_array($nextInstallmentForCustomer) && !isset($nextInstallmentForCustomer['error']))
                                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3">
                                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-700">งวดที่ต้องจ่ายตอนนี้</p>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-emerald-900">
                                        <span class="font-semibold">งวด {{ $nextInstallmentForCustomer['round'] }}</span>
                                        <span>ครบกำหนด {{ $nextInstallmentForCustomer['due_date']->format('d/m/Y') }}</span>
                                        <span class="font-black">฿{{ number_format((float) $nextInstallmentForCustomer['amount'], 2) }}</span>
                                    </div>
                                </div>
                            @elseif(is_array($nextInstallmentForCustomer) && isset($nextInstallmentForCustomer['error']))
                                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                                    {{ $nextInstallmentForCustomer['error'] }}
                                </div>
                            @endif
                        @endif

                        <form wire:submit.prevent="submitProjectPayment" class="space-y-3 mb-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Upload Slip</label>
                                <input type="file"
                                       wire:model="projectPaymentSlip"
                                       accept="image/*,.pdf"
                                       class="w-full border border-gray-200 px-3 py-2 rounded-lg text-xs" />
                                <div wire:loading wire:target="projectPaymentSlip" class="text-xs text-blue-600 mt-1 font-medium">Uploading...</div>
                                @if($projectPaymentSlip)
                                    <p class="text-xs text-gray-500 mt-1">{{ $projectPaymentSlip->getClientOriginalName() }}</p>
                                @endif
                                @error('projectPaymentSlip') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Amount</label>
                                @if($project->total_price !== null && is_array($nextInstallmentForCustomer) && !isset($nextInstallmentForCustomer['error']))
                                    <input type="text" value="฿{{ number_format((float) $nextInstallmentForCustomer['amount'], 2) }} (งวด {{ $nextInstallmentForCustomer['round'] }})" class="w-full border border-emerald-200 bg-emerald-50 px-3 py-2 rounded-lg text-sm font-semibold text-emerald-800" readonly />
                                @else
                                    <input type="number" step="0.01" min="0.01" wire:model.defer="projectPaymentAmount" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm" placeholder="0.00" />
                                @endif
                                @error('projectPaymentAmount') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Transfer Date & Time</label>
                                <input type="datetime-local" wire:model.defer="projectPaymentTransferAt" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm" />
                                @error('projectPaymentTransferAt') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Note (Optional)</label>
                                <textarea wire:model.defer="projectPaymentNote" rows="2" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm resize-none" placeholder="รายละเอียดเพิ่มเติม"></textarea>
                                @error('projectPaymentNote') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" wire:loading.attr="disabled" @disabled($project->total_price !== null && is_array($nextInstallmentForCustomer) && isset($nextInstallmentForCustomer['error'])) class="w-full px-4 py-2.5 bg-sky-600 text-white rounded-lg text-sm font-semibold hover:bg-sky-700 disabled:opacity-50 transition">
                                <span wire:loading.remove wire:target="submitProjectPayment">ส่งสลิปชำระเงิน</span>
                                <span wire:loading wire:target="submitProjectPayment">กำลังส่ง...</span>
                            </button>
                        </form>

                        <div class="space-y-2">
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-600">ประวัติของฉันในโปรเจ็คนี้</p>
                            @forelse($myProjectPayments->take(8) as $payment)
                                <div class="rounded-lg border border-gray-100 p-3 bg-gray-50">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <p class="text-xs font-semibold text-gray-900 truncate">{{ $payment->user?->name ?? 'Unknown' }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $payment->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $payment->status }}</span>
                                            <a href="{{ $payment->slip_file_url }}" target="_blank" class="text-[11px] font-semibold text-sky-700 hover:text-sky-800">ดูสลิป</a>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                                    @if($payment->transfer_at)
                                        <p class="text-[11px] text-gray-600 mt-1">โอนเมื่อ {{ $payment->transfer_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                    @if($payment->installment_round)
                                        <p class="text-[11px] font-semibold text-indigo-700 mt-1">งวดที่ {{ $payment->installment_round }}</p>
                                    @endif
                                    <p class="text-xs font-semibold text-gray-700 mt-1">฿{{ number_format($payment->amount, 2) }}</p>
                                    @if($payment->reviewed_amount)
                                        <p class="text-xs text-gray-600 mt-1">ยอดที่ตรวจสอบ: ฿{{ number_format($payment->reviewed_amount, 2) }}</p>
                                    @endif
                                    @if($payment->review_note)
                                        <p class="text-xs text-gray-600 mt-1 whitespace-pre-line">{{ $payment->review_note }}</p>
                                    @endif
                                </div>
                            @empty
                                <p class="text-xs font-medium text-gray-500 text-center py-4 border border-dashed border-gray-200 rounded-lg">ยังไม่มีประวัติการชำระเงิน</p>
                            @endforelse
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-amber-700">Pending Customer Slips</p>
                                <p class="text-xl font-black text-amber-800">{{ $pendingCustomerPayments->count() }}</p>
                            </div>
                            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-700">Customer Rounds</p>
                                <p class="text-xl font-black text-emerald-800">{{ $freelancePaymentStats['customer_rounds'] }}</p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-600">ประวัติการชำระเงินในโปรเจ็คนี้</p>
                            @forelse($projectPayments->take(12) as $payment)
                                <div class="rounded-lg border p-3 {{ $payment->status === 'pending' && $payment->submitted_as === 'customer' ? 'border-amber-200 bg-amber-50' : 'border-gray-100 bg-gray-50' }}">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <p class="text-xs font-semibold text-gray-900 truncate">
                                            {{ $payment->user?->name ?? 'Unknown' }}
                                            <span class="text-[10px] font-bold uppercase ml-1 {{ $payment->submitted_as === 'customer' ? 'text-emerald-700' : 'text-blue-700' }}">{{ $payment->submitted_as }}</span>
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $payment->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ $payment->status }}</span>
                                            <a href="{{ $payment->slip_file_url }}" target="_blank" class="text-[11px] font-semibold text-sky-700 hover:text-sky-800">ดูสลิป</a>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
                                    @if($payment->transfer_at)
                                        <p class="text-[11px] text-gray-600 mt-1">โอนเมื่อ {{ $payment->transfer_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                    @if($payment->installment_round)
                                        <p class="text-[11px] font-semibold text-indigo-700 mt-1">งวดที่ {{ $payment->installment_round }}</p>
                                    @endif
                                    <p class="text-xs font-semibold text-gray-700 mt-1">฿{{ number_format($payment->amount, 2) }}</p>
                                    @if($payment->reviewed_amount)
                                        <p class="text-xs text-gray-600 mt-1">ยอดที่ตรวจสอบ: ฿{{ number_format($payment->reviewed_amount, 2) }}</p>
                                    @endif
                                    @if($payment->reviewer)
                                        <p class="text-xs text-gray-500 mt-1">ตรวจสอบโดย {{ $payment->reviewer->name }}{{ $payment->reviewed_at ? ' • ' . $payment->reviewed_at->format('d/m/Y H:i') : '' }}</p>
                                    @endif
                                    @if($payment->review_note)
                                        <p class="text-xs text-gray-600 mt-1 whitespace-pre-line">{{ $payment->review_note }}</p>
                                    @endif
                                    @if($canReviewCustomerPayment && $payment->submitted_as === 'customer' && $payment->status === 'pending')
                                        <div class="mt-3 pt-3 border-t border-amber-200 space-y-2">
                                            <p class="text-[11px] font-semibold text-amber-800">รายการนี้รอ Freelance Owner ตรวจสอบ</p>
                                            <div>
                                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-1">Reviewed Amount</label>
                                                <input type="number" step="0.01" min="0" wire:model.defer="paymentReviewAmounts.{{ $payment->id }}" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm bg-white" placeholder="0.00" />
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-1">Reason / Note</label>
                                                <textarea wire:model.defer="paymentReviewNotes.{{ $payment->id }}" rows="2" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm bg-white resize-none" placeholder="กรอกเหตุผลเมื่อไม่อนุมัติ หรือใส่หมายเหตุเพิ่มเติม"></textarea>
                                                <p class="mt-1 text-[11px] text-gray-500">ถ้าไม่อนุมัติ ต้องกรอกเหตุผลก่อนกดส่งคืน</p>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <button type="button" wire:click="approveProjectPayment({{ $payment->id }})" wire:loading.attr="disabled" class="px-3 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 disabled:opacity-50 transition">Approve</button>
                                                <button type="button" wire:click="rejectProjectPayment({{ $payment->id }})" wire:loading.attr="disabled" class="px-3 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 disabled:opacity-50 transition">ส่งคืน</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-xs font-medium text-gray-500 text-center py-4 border border-dashed border-gray-200 rounded-lg">ยังไม่มีประวัติการชำระเงิน</p>
                            @endforelse
                        </div>
                    @endif
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['customer', 'freelance']))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-4 bg-gradient-to-b from-emerald-600 to-emerald-400 rounded-full"></div>
                        <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest">Project Chat</h4>
                    </div>

                    @if(auth()->user()->role === 'freelance' && $project->customers->count() > 1)
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Select Customer</label>
                            <select wire:model.live="chatTargetCustomerId" class="w-full border border-gray-200 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                                <option value="">Choose customer...</option>
                                @foreach($project->customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif(auth()->user()->role === 'freelance' && $project->customers->count() === 1)
                        <div class="mb-3 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2">
                            <p class="text-xs font-semibold text-emerald-800">กำลังคุยกับ: {{ $project->customers->first()->name }}</p>
                        </div>
                    @endif

                    @if(!$project->freelance_id)
                        <p class="text-xs font-medium text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">ยังไม่มีฟรีแลนซ์ประจำโปรเจค จึงยังไม่สามารถเริ่มแชทได้</p>
                    @elseif(auth()->user()->role === 'freelance' && !$chatCounterpartId)
                        <p class="text-xs font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">เลือก Customer ก่อนเพื่อเริ่มแชท</p>
                    @else
                        <div wire:poll.10s class="space-y-2 border border-gray-200 rounded-lg p-3 h-64 overflow-y-auto bg-gray-50">
                            @forelse($chatMessages as $message)
                                <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                    <div class="inline-block max-w-[85%] rounded-lg px-3 py-2 {{ $message->sender_id === auth()->id() ? 'bg-emerald-600 text-white' : 'bg-white border border-gray-200 text-gray-800' }}">
                                        <p class="text-[11px] font-semibold {{ $message->sender_id === auth()->id() ? 'text-emerald-100' : 'text-gray-500' }} mb-1">
                                            {{ $message->sender?->name ?? 'Unknown' }} • {{ $message->created_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-sm whitespace-pre-line">{{ $message->message }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs font-medium text-gray-500 text-center py-6">ยังไม่มีข้อความ เริ่มคุยได้เลย</p>
                            @endforelse
                        </div>

                        <form wire:submit.prevent="sendChatMessage" class="mt-3 flex gap-2">
                            <input type="text" wire:model.defer="newChatMessage" placeholder="พิมพ์ข้อความ..." class="flex-1 border border-gray-200 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition" />
                            <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 disabled:opacity-50 transition">
                                ส่ง
                            </button>
                        </form>
                        @error('newChatMessage') <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                    @endif
                </div>
            @endif

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
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('showEditModal', false)"></div>
            <div class="relative z-[1001] w-full max-w-2xl max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden pointer-events-auto">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Edit Project Details</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5">
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
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Total Price</label>
                                <input type="number" min="0.01" step="0.01" wire:model.defer="totalPrice" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="0.00" />
                                @error('totalPrice') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Installments</label>
                                <input type="number" min="1" max="120" wire:model.defer="installmentCount" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                @error('installmentCount') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Due Day</label>
                                <input type="number" min="1" max="28" wire:model.defer="dueDayOfMonth" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                @error('dueDayOfMonth') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        @if($status === 'cancelled')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Cancellation Reason</label>
                                <textarea wire:model.defer="cancelReason" rows="3" class="w-full border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none" placeholder="กรอกเหตุผลการยกเลิกโปรเจกต์..."></textarea>
                                @error('cancelReason') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                        @endif

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
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('showEditCustomersModal', false)"></div>
            <div class="relative z-[1001] w-full max-w-2xl max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Manage Customers</h3>
                    <button wire:click="$set('showEditCustomersModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5">
                    <form wire:submit.prevent="updateCustomers" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Customer (Only 1)</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="customerSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchCustomers" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                @php($hasCustomerSearch = trim((string) $customerSearchQuery) !== '')
                                @if(!$hasCustomerSearch)
                                    <p class="text-sm font-medium text-gray-500 text-center py-8">พิมพ์ค้นหา Customer ก่อน</p>
                                @else
                                    @forelse($customers as $customer)
                                        <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition group">
                                            <input type="radio" wire:model.defer="selectedCustomer" value="{{ $customer->id }}" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                            <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-8 h-8 rounded-full flex-shrink-0" />
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900">{{ $customer->name }}</p>
                                                <p class="text-xs text-gray-600 truncate">{{ $customer->email }}</p>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-sm font-medium text-gray-500 text-center py-8">No customers found</p>
                                    @endforelse
                                @endif
                            </div>
                            @error('selectedCustomer') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
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

    <!-- Edit Team Members Modal -->
    @if($showEditTeamMembersModal)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('showEditTeamMembersModal', false)"></div>
            <div class="relative z-[1001] w-full max-w-2xl max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden pointer-events-auto">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Manage Team Member</h3>
                    <button wire:click="$set('showEditTeamMembersModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5">
                    <form wire:submit.prevent="updateTeamMembers" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Team Member (Only 1)</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="teamMemberSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchTeamMembers" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                @php($hasTeamMemberSearch = trim((string) $teamMemberSearchQuery) !== '')
                                @if(!$hasTeamMemberSearch)
                                    <p class="text-sm text-gray-500 text-center py-8">พิมพ์ค้นหา Team Member ก่อน</p>
                                @else
                                    @forelse($availableTeamMembers as $member)
                                        <label class="flex items-center gap-3 cursor-pointer hover:bg-blue-50 px-3 py-2.5 rounded-lg transition group">
                                            <input type="radio" wire:model.defer="selectedTeamMember" value="{{ $member->id }}" class="w-4 h-4 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                            <img src="{{ $member->profile_image_url }}" alt="{{ $member->name }}" class="w-8 h-8 rounded-full flex-shrink-0" />
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900">{{ $member->name }}</p>
                                                <p class="text-xs text-gray-600 truncate">{{ $member->email }} • {{ ucfirst($member->role) }}</p>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500 text-center py-8">No team members found</p>
                                    @endforelse
                                @endif
                            </div>
                            @error('selectedTeamMember') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200">
                            <button type="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="updateTeamMembers">Save Changes</span>
                                <span wire:loading wire:target="updateTeamMembers" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showEditTeamMembersModal', false)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Freelance Modal -->
    @if($showEditFreelanceModal)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('showEditFreelanceModal', false)"></div>
            <div class="relative z-[1001] w-full max-w-lg max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden pointer-events-auto">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="text-lg font-black text-gray-900">Assign Freelance</h3>
                    <button wire:click="$set('showEditFreelanceModal', false)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5">
                    <form wire:submit.prevent="updateFreelance" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-widest">Select Freelance (Only 1)</label>
                            <div class="flex gap-2 mb-4">
                                <input type="text" wire:model.defer="freelanceSearchQuery" placeholder="Search by email or name..." class="flex-1 border border-gray-200 px-4 py-2.5 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                                <button type="button" wire:click="searchFreelance" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Search</button>
                            </div>
                            <div class="space-y-1 border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto bg-white">
                                @php($hasFreelanceSearch = trim((string) $freelanceSearchQuery) !== '')
                                @if(!$hasFreelanceSearch)
                                    <p class="text-sm text-gray-500 text-center py-8">พิมพ์ค้นหา Freelance ก่อน</p>
                                @else
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
                                @endif
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
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="$set('confirmingDeleteId', null)"></div>
            <div class="relative z-[1001] w-full max-w-md rounded-2xl bg-white shadow-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-red-50">
                    <h3 class="text-lg font-black text-gray-900">Delete Project</h3>
                    <button wire:click="$set('confirmingDeleteId', null)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Delete this project?</p>
                            <p class="text-xs text-gray-600">This action cannot be undone.</p>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-6">Are you sure you want to delete this project? This will also delete all tasks.</p>
                    <div class="flex gap-3">
                        <button type="button" wire:click.prevent="deleteProject" wire:loading.attr="disabled" wire:target="deleteProject" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="deleteProject">Delete</span>
                            <span wire:loading wire:target="deleteProject" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                Deleting...
                            </span>
                        </button>
                        <button wire:click="$set('confirmingDeleteId', null)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Task Confirmation -->
    @if($confirmingDeleteTaskId)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('confirmingDeleteTaskId', null)"></div>
            <div class="relative z-[1001] w-full max-w-md max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-red-50">
                    <h3 class="text-lg font-black text-gray-900">Delete Task</h3>
                    <button type="button" wire:click.prevent="$set('confirmingDeleteTaskId', null)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-700 mb-6">Are you sure you want to delete this task? This action cannot be undone.</p>
                    <div class="flex gap-3">
                        <button type="button" wire:click.prevent="deleteTask" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="deleteTask">Delete</span>
                            <span wire:loading wire:target="deleteTask">Deleting...</span>
                        </button>
                        <button type="button" wire:click.prevent="$set('confirmingDeleteTaskId', null)" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete File Confirmation -->
    @if($confirmingDeleteFileId)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 z-[999] pointer-events-auto cursor-pointer" wire:click="$set('confirmingDeleteFileId', null)"></div>
            <div class="relative z-[1001] w-full max-w-md max-h-[90vh] bg-white shadow-2xl border border-gray-100 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-red-50">
                    <h3 class="text-lg font-black text-gray-900">Delete File</h3>
                    <button wire:click="$set('confirmingDeleteFileId', null)" class="text-gray-400 hover:text-gray-600 transition text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z" />
                            </svg>
                        </div>
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
