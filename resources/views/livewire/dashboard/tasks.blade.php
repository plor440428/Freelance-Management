<div class="space-y-6 sm:space-y-8" style="font-family: 'IBM Plex Sans Thai', sans-serif;">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-3xl sm:text-4xl font-semibold text-slate-900">งานของฉัน</h3>
            <p class="text-sm sm:text-base text-slate-600 mt-2">งานที่มอบหมายหรือสร้างโดยคุณ</p>
        </div>
        <div class="text-xs sm:text-sm text-slate-500 bg-slate-50 px-4 py-2 rounded-lg border border-slate-200">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <!-- Task Stats with Gradient Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
        <!-- Total Tasks -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-7 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-slate-600 uppercase tracking-wide mb-2">งานทั้งหมด</p>
                    <p class="text-4xl sm:text-5xl font-bold text-sky-600">{{ $tasks->count() }}</p>
                </div>
                <div class="p-3 sm:p-4 bg-sky-100/50 group-hover:bg-sky-100 rounded-2xl transition-colors">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Todo Tasks -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-7 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-slate-600 uppercase tracking-wide mb-2">รอดำเนินการ</p>
                    <p class="text-4xl sm:text-5xl font-bold text-amber-500">{{ $tasks->where('status', 'todo')->count() }}</p>
                </div>
                <div class="p-3 sm:p-4 bg-amber-100/50 group-hover:bg-amber-100 rounded-2xl transition-colors">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- In Progress Tasks -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-7 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-slate-600 uppercase tracking-wide mb-2">กำลังทำ</p>
                    <p class="text-4xl sm:text-5xl font-bold text-purple-600">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="p-3 sm:p-4 bg-purple-100/50 group-hover:bg-purple-100 rounded-2xl transition-colors">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-7 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-slate-600 uppercase tracking-wide mb-2">เสร็จสิ้น</p>
                    <p class="text-4xl sm:text-5xl font-bold text-emerald-500">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
                <div class="p-3 sm:p-4 bg-emerald-100/50 group-hover:bg-emerald-100 rounded-2xl transition-colors">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 sm:p-7 hover:shadow-md transition-all">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Search -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-2.5 uppercase tracking-wide">ค้นหา</label>
                <input type="text" wire:model.live="searchTerm" placeholder="ค้นหางาน..." class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all hover:border-slate-400">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-2.5 uppercase tracking-wide">สถานะ</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all cursor-pointer hover:border-slate-400">
                    <option value="all">ทุกสถานะ</option>
                    <option value="todo">รอดำเนินการ</option>
                    <option value="in_progress">กำลังทำ</option>
                    <option value="completed">เสร็จสิ้น</option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-2.5 uppercase tracking-wide">ความสำคัญ</label>
                <select wire:model.live="filterPriority" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all cursor-pointer hover:border-slate-400">
                    <option value="all">ทุกระดับ</option>
                    <option value="high">สูง</option>
                    <option value="medium">ปานกลาง</option>
                    <option value="low">ต่ำ</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Project Accordion List -->
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h4 class="text-xl font-semibold text-slate-900">โปรเจกต์และงาน</h4>
            <p class="text-sm text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg">
                แสดง <strong class="text-slate-900">{{ $projectGroups->count() }}</strong> โปรเจกต์
            </p>
        </div>

        @if($projectGroups->count() > 0)
            @foreach($projectGroups as $projectId => $group)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-all">
                    <!-- Accordion Header -->
                    <div class="p-6 sm:p-7 cursor-pointer hover:bg-slate-50 transition-colors" wire:click="toggleAccordion({{ $projectId }})">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <!-- Toggle Icon -->
                                <svg class="w-5 h-5 text-slate-400 transition-transform {{ in_array($projectId, $openAccordions) ? 'rotate-90' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                        <svg class="w-5 h-5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                        <h4 class="font-semibold text-slate-900 truncate">{{ $group['project']->name }}</h4>
                                        <button wire:click.stop="viewProject({{ $projectId }})" class="px-3 py-1 text-xs bg-sky-100 hover:bg-sky-200 text-sky-800 rounded-lg font-medium transition-colors">
                                            ดู
                                        </button>
                                    </div>
                                    <p class="text-xs text-slate-600 ml-7">
                                        สร้างโดย <span class="text-slate-900 font-medium">{{ $group['project']->creator->name }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Task Stats -->
                            <div class="flex items-center gap-5 sm:gap-6 text-sm ml-8 lg:ml-0">
                                <div class="text-center">
                                    <div class="font-bold text-slate-900 text-base">{{ $group['stats']['total'] }}</div>
                                    <div class="text-xs text-slate-600">ทั้งหมด</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-amber-500 text-base">{{ $group['stats']['todo'] }}</div>
                                    <div class="text-xs text-amber-600">รอทำ</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-purple-600 text-base">{{ $group['stats']['in_progress'] }}</div>
                                    <div class="text-xs text-purple-600">กำลังทำ</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-emerald-500 text-base">{{ $group['stats']['completed'] }}</div>
                                    <div class="text-xs text-emerald-600">เสร็จ</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    @if(in_array($projectId, $openAccordions))
                        <div class="border-t border-slate-200 bg-gradient-to-b from-slate-50 to-white">
                            <!-- Project Status Filter -->
                            <div class="p-5 sm:p-6 border-b border-slate-200 bg-white" onclick="event.stopPropagation()">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                    <label class="text-sm font-medium text-slate-700">กรอง:</label>
                                    <select wire:model.live="projectStatusFilters.{{ $projectId }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all cursor-pointer hover:border-slate-400">
                                        <option value="all">ทุกสถานะ</option>
                                        <option value="todo">รอดำเนินการ ({{ $group['stats']['todo'] }})</option>
                                        <option value="in_progress">กำลังทำ ({{ $group['stats']['in_progress'] }})</option>
                                        <option value="completed">เสร็จสิ้น ({{ $group['stats']['completed'] }})</option>
                                    </select>
                                    <span class="text-sm text-slate-600 sm:ml-auto bg-slate-50 px-3 py-1.5 rounded-lg">
                                        แสดง <strong class="text-slate-900">{{ $group['tasks']->count() }}</strong> จาก {{ $group['stats']['total'] }} งาน
                                    </span>
                                </div>
                            </div>

                            <!-- Task List -->
                            <div class="divide-y divide-slate-200">
                            @foreach($group['tasks'] as $task)
                                <div class="p-5 sm:p-6 hover:bg-sky-50/50 transition-colors cursor-pointer" wire:click="viewTask({{ $task->id }})">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2 flex-wrap">
                                                <div class="flex-shrink-0">
                                                    @if($task->status === 'completed')
                                                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    @elseif($task->status === 'in_progress')
                                                        <svg class="w-5 h-5 text-purple-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <h5 class="font-medium text-slate-900 truncate">{{ $task->title }}</h5>

                                                <!-- Status Badge -->
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap
                                                    @if($task->status === 'completed') bg-emerald-100 text-emerald-700
                                                    @elseif($task->status === 'in_progress') bg-purple-100 text-purple-700
                                                    @else bg-slate-100 text-slate-700
                                                    @endif">
                                                    @if($task->status === 'completed') เสร็จสิ้น
                                                    @elseif($task->status === 'in_progress') กำลังทำ
                                                    @else รอดำเนินการ
                                                    @endif
                                                </span>

                                                <!-- Priority Badge -->
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap
                                                    @if($task->priority === 'high') bg-red-100 text-red-700
                                                    @elseif($task->priority === 'medium') bg-amber-100 text-amber-700
                                                    @else bg-slate-100 text-slate-700
                                                    @endif">
                                                    @if($task->priority === 'high') สูง
                                                    @elseif($task->priority === 'medium') ปานกลาง
                                                    @else ต่ำ
                                                    @endif
                                                </span>
                                            </div>

                                            @if($task->description)
                                                <p class="text-sm text-slate-600 mb-2 line-clamp-2">{{ $task->description }}</p>
                                            @endif

                                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                                <!-- Assignee -->
                                                @if($task->assignee)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ $task->assignee->profile_image_url }}" alt="{{ $task->assignee->name }}" class="w-5 h-5 rounded-full ring-2 ring-white">
                                                        <span class="font-medium text-slate-700">{{ $task->assignee->name }}</span>
                                                    </div>
                                                @endif

                                                <!-- Due Date -->
                                                @if($task->due_date)
                                                    <div class="flex items-center gap-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 font-medium' : '' }}">
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
                                        <div class="shrink-0 sm:mt-0" onclick="event.stopPropagation()">
                                            <select wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)"
                                                class="px-3 py-2 border border-slate-300 rounded-xl text-xs font-medium cursor-pointer focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all hover:border-slate-400">
                                                <option value="todo" @selected($task->status === 'todo')>รอดำเนินการ</option>
                                                <option value="in_progress" @selected($task->status === 'in_progress')>กำลังทำ</option>
                                                <option value="completed" @selected($task->status === 'completed')>เสร็จสิ้น</option>
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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-12 sm:p-16 text-center hover:shadow-md transition-all">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-2">ไม่พบงาน</h3>
                <p class="text-sm sm:text-base text-slate-600">คุณยังไม่มีงานที่มอบหมาย</p>
            </div>
        @endif
    </div>

    <!-- Task Detail Modal -->
    @if($showTaskDetail && $selectedTask)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="closeTaskDetail"></div>
            <div class="absolute inset-y-0 right-0 h-full w-full max-w-2xl bg-white shadow-2xl ring-1 ring-slate-200 flex flex-col z-[1001]">
                <!-- Header -->
                <div class="shrink-0 bg-gradient-to-r from-sky-50 to-white px-6 py-5 flex items-center justify-between border-b border-slate-200">
                    <div>
                        <p class="text-xs font-medium text-sky-600 uppercase tracking-wide mb-1">รายละเอียดงาน</p>
                        <p class="text-2xl font-semibold text-slate-900">{{ $selectedTask->title }}</p>
                    </div>
                    <button wire:click="closeTaskDetail" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 py-5 space-y-6" style="max-height: calc(100vh - 80px);">
                    <!-- Status & Priority -->
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3 py-1.5 rounded-xl text-sm font-medium
                            @if($selectedTask->status === 'completed') bg-emerald-100 text-emerald-700
                            @elseif($selectedTask->status === 'in_progress') bg-purple-100 text-purple-700
                            @else bg-slate-100 text-slate-700
                            @endif">
                            @if($selectedTask->status === 'completed') เสร็จสิ้น
                            @elseif($selectedTask->status === 'in_progress') กำลังทำ
                            @else รอดำเนินการ
                            @endif
                        </span>
                        <span class="px-3 py-1.5 rounded-xl text-sm font-medium
                            @if($selectedTask->priority === 'high') bg-red-100 text-red-700
                            @elseif($selectedTask->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-700
                            @endif">
                            @if($selectedTask->priority === 'high') ความสำคัญสูง
                            @elseif($selectedTask->priority === 'medium') ความสำคัญปานกลาง
                            @else ความสำคัญต่ำ
                            @endif
                        </span>
                    </div>

                    <!-- Description -->
                    @if($selectedTask->description)
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center text-base">
                                <svg class="w-5 h-5 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                คำอธิบาย
                            </h4>
                            <p class="text-slate-700 leading-relaxed">{{ $selectedTask->description }}</p>
                        </div>
                    @endif

                    <!-- Task Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-200">
                        <!-- Project -->
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">โปรเจกต์</h4>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <svg class="w-5 h-5 text-sky-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="font-medium text-slate-900">{{ $selectedTask->project->name }}</span>
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">มอบหมายให้</h4>
                            @if($selectedTask->assignee)
                                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                    <img src="{{ $selectedTask->assignee->profile_image_url }}" alt="{{ $selectedTask->assignee->name }}" class="w-10 h-10 rounded-full flex-shrink-0 ring-2 ring-white">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900 truncate">{{ $selectedTask->assignee->name }}</p>
                                        <p class="text-xs text-slate-600 truncate">{{ $selectedTask->assignee->email }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-slate-600 text-sm">ยังไม่มอบหมาย</div>
                            @endif
                        </div>

                        <!-- Due Date -->
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">กำหนดส่ง</h4>
                            @if($selectedTask->due_date)
                                <div class="flex items-center gap-3 p-4 rounded-xl {{ $selectedTask->due_date->isPast() && $selectedTask->status !== 'completed' ? 'bg-red-50 border-2 border-red-300' : 'bg-slate-50 border border-slate-200' }}">
                                    <svg class="w-5 h-5 flex-shrink-0 {{ $selectedTask->due_date->isPast() && $selectedTask->status !== 'completed' ? 'text-red-600' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $selectedTask->due_date->format('F d, Y') }}</p>
                                        @if($selectedTask->due_date->isPast() && $selectedTask->status !== 'completed')
                                            <p class="text-xs text-red-600 font-medium">เกินกำหนด</p>
                                        @else
                                            <p class="text-xs text-slate-600">{{ $selectedTask->due_date->diffForHumans() }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-slate-600 text-sm">ไม่มีกำหนด</div>
                            @endif
                        </div>

                        <!-- Created Date -->
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">สร้างเมื่อ</h4>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <p class="font-medium text-slate-900">{{ $selectedTask->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-slate-600">{{ $selectedTask->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="sticky bottom-0 bg-white border-t border-slate-200 p-6">
                    <button wire:click="closeTaskDetail" class="w-full px-4 py-3 bg-sky-600 text-white rounded-xl font-medium hover:bg-sky-700 transition-colors">
                        ปิด
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Project Detail Modal -->
    @if($showProjectDetail && $selectedProject)
        <div class="fixed inset-0 z-[1000] overflow-hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-[1000]" wire:click="closeProjectDetail"></div>
            <div class="absolute inset-y-0 right-0 h-full w-full max-w-3xl bg-white shadow-2xl ring-1 ring-slate-200 flex flex-col z-[1001]">
                <!-- Header -->
                <div class="shrink-0 bg-gradient-to-r from-purple-50 to-white px-6 py-5 flex items-center justify-between border-b border-slate-200">
                    <div>
                        <p class="text-xs font-medium text-purple-600 uppercase tracking-wide mb-1">รายละเอียดโปรเจกต์</p>
                        <p class="text-2xl font-semibold text-slate-900">{{ $selectedProject->name }}</p>
                    </div>
                    <button wire:click="closeProjectDetail" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto overflow-x-hidden px-6 py-5 space-y-6" style="max-height: calc(100vh - 80px);">
                    <!-- Description -->
                    @if($selectedProject->description)
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center text-base">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                คำอธิบาย
                            </h4>
                            <p class="text-slate-700 leading-relaxed">{{ $selectedProject->description }}</p>
                        </div>
                    @endif

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-200">
                        <!-- Creator -->
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">สร้างโดย</h4>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <img src="{{ $selectedProject->creator->profile_image_url }}" alt="{{ $selectedProject->creator->name }}" class="w-12 h-12 rounded-full flex-shrink-0 ring-2 ring-white">
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-900 truncate">{{ $selectedProject->creator->name }}</p>
                                    <p class="text-xs text-slate-600 truncate">{{ $selectedProject->creator->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Freelance Owner -->
                        @if($selectedProject->freelance)
                            <div>
                                <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-3">ฟรีแลนซ์</h4>
                                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                    <img src="{{ $selectedProject->freelance->profile_image_url }}" alt="{{ $selectedProject->freelance->name }}" class="w-12 h-12 rounded-full flex-shrink-0 ring-2 ring-white">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900 truncate">{{ $selectedProject->freelance->name }}</p>
                                        <p class="text-xs text-slate-600 truncate">{{ $selectedProject->freelance->email }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-slate-600">
                                <p class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-2">ฟรีแลนซ์</p>
                                <p>ยังไม่มอบหมาย</p>
                            </div>
                        @endif
                    </div>

                    <!-- Project Managers -->
                    @if($selectedProject->managers->count() > 0)
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                ผู้จัดการโปรเจกต์
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->managers as $manager)
                                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                        <img src="{{ $manager->profile_image_url }}" alt="{{ $manager->name }}" class="w-10 h-10 rounded-full flex-shrink-0 ring-2 ring-white">
                                        <div class="min-w-0">
                                            <p class="font-medium text-sm text-slate-900 truncate">{{ $manager->name }}</p>
                                            <p class="text-xs text-slate-600 truncate">{{ $manager->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Customers -->
                    @if($selectedProject->customers->count() > 0)
                        <div>
                            <h4 class="text-xs font-medium text-slate-700 uppercase tracking-wide mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 20H9m8-4h.01M15 16h.01M9 20H5v-2a3 3 0 015.856-1.487M9 16H9.01" />
                                </svg>
                                ลูกค้า
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedProject->customers as $customer)
                                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                        <img src="{{ $customer->profile_image_url }}" alt="{{ $customer->name }}" class="w-10 h-10 rounded-full flex-shrink-0 ring-2 ring-white">
                                        <div class="min-w-0">
                                            <p class="font-medium text-sm text-slate-900 truncate">{{ $customer->name }}</p>
                                            <p class="text-xs text-slate-600 truncate">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="sticky bottom-0 bg-white border-t border-slate-200 p-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        @php
                            $user = auth()->user();
                            $canManageProject = $user->role === 'admin'
                                || $selectedProject->created_by === $user->id
                                || $selectedProject->freelance_id === $user->id
                                || $selectedProject->managers->contains($user->id);
                        @endphp

                        @if($canManageProject && ($user->role === 'admin' || $selectedProject->created_by === $user->id || $selectedProject->freelance_id === $user->id))
                            <a href="{{ route('dashboard.projects.detail', $selectedProject->id) }}"
                               class="flex-1 px-4 py-3 bg-sky-600 text-white rounded-xl text-center hover:bg-sky-700 font-medium transition-colors">
                                ไปที่โปรเจกต์
                            </a>
                        @endif
                        <button wire:click="closeProjectDetail" class="flex-1 px-4 py-3 border border-slate-300 text-slate-700 rounded-xl font-medium hover:bg-slate-50 transition-colors">
                            ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
