<div class="space-y-8" style="font-family: 'IBM Plex Sans Thai', sans-serif;">
    @if(auth()->user()->role === 'admin')
        <!-- Admin Dashboard -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="dash-title text-3xl font-semibold text-slate-900">Admin Dashboard</h3>
                <p class="text-sm sm:text-base text-slate-600 mt-2">ภาพรวมระบบและสถิติทั้งหมด</p>
            </div>
            <div class="text-xs sm:text-sm text-slate-500 bg-slate-50 px-4 py-2 rounded-lg border border-slate-200">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="dash-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            <!-- Total Projects -->
            <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl shadow-md hover:shadow-lg p-6 sm:p-7 text-white transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sky-100 text-sm font-medium mb-2">โปรเจกต์ทั้งหมด</p>
                        <p class="text-4xl sm:text-5xl font-bold">{{ $totalProjects }}</p>
                        <p class="text-sky-100 text-xs sm:text-sm mt-3">
                            {{ $activeProjects }} ดำเนินการ • {{ $completedProjects }} เสร็จสิ้น
                        </p>
                    </div>
                    <div class="p-3 sm:p-4 bg-white/20 rounded-2xl">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-md hover:shadow-lg p-6 sm:p-7 text-white transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-purple-100 text-sm font-medium mb-2">ผู้ใช้ทั้งหมด</p>
                        <p class="text-4xl sm:text-5xl font-bold">{{ $totalUsers }}</p>
                        <p class="text-purple-100 text-xs sm:text-sm mt-3">
                            {{ $approvedUsers }} อนุมัติแล้ว • {{ $pendingApprovals }} รออนุมัติ
                        </p>
                    </div>
                    <div class="p-3 sm:p-4 bg-white/20 rounded-2xl">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-md hover:shadow-lg p-6 sm:p-7 text-white transform hover:scale-[1.02] transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-green-100 text-sm font-medium mb-2">งานทั้งหมด</p>
                        <p class="text-4xl sm:text-5xl font-bold">{{ $totalTasks }}</p>
                        <p class="text-green-100 text-xs sm:text-sm mt-3">
                            {{ $inProgressTasks }} กำลังทำ • {{ $completedTasks }} เสร็จแล้ว
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium mb-1">รออนุมัติ</p>
                        <p class="text-4xl font-bold">{{ $pendingApprovals }}</p>
                        <p class="text-orange-100 text-xs mt-2">
                            ผู้ใช้ที่รอการอนุมัติ
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="dash-grid grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- User Role Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h4 class="font-bold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    การกระจายผู้ใช้ตาม Role
                </h4>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="userRoleChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
                        <p class="text-slate-600 mt-1">Admin: {{ $adminUsers }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                        <p class="text-slate-600 mt-1">Freelance: {{ $freelanceUsers }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                        <p class="text-slate-600 mt-1">Customer: {{ $customerUsers }}</p>
                    </div>
                </div>
            </div>

            <!-- Project Status Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h4 class="font-bold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    สถานะโปรเจกต์
                </h4>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="projectStatusChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                        <p class="text-slate-600 mt-1">Active: {{ $activeProjects }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                        <p class="text-slate-600 mt-1">Completed: {{ $completedProjects }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                        <p class="text-slate-600 mt-1">Pending: {{ $pendingProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Projects Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b">
                <h4 class="font-bold text-slate-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    โปรเจกต์ล่าสุด
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">ชื่อโปรเจกต์</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">ผู้สร้าง</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">สถานะ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">วันที่อัพเดท</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($recentProjects as $project)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $project->name }}</div>
                                    <div class="text-xs text-slate-500">{{ Str::limit($project->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $project->creator->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($project->status === 'active') bg-green-100 text-green-800
                                        @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $project->updated_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    ไม่มีโปรเจกต์
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @elseif(auth()->user()->role === 'freelance')
        <!-- Freelance Dashboard -->
        <div class="flex items-center justify-between">
            <div>
                <h3 class="dash-title text-3xl font-bold text-slate-900">สวัสดี, {{ auth()->user()->name }}!</h3>
                <p class="text-sm text-slate-600 mt-1">ภาพรวมโปรเจกต์และงานของคุณ</p>
            </div>
            <div class="text-sm text-slate-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="dash-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Projects -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">โปรเจกต์ทั้งหมด</p>
                        <p class="text-4xl font-bold">{{ $totalProjects }}</p>
                        <p class="text-blue-100 text-xs mt-2">
                            {{ $activeProjects }} ดำเนินการ • {{ $completedProjects }} เสร็จสิ้น
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">งานทั้งหมด</p>
                        <p class="text-4xl font-bold">{{ $totalTasks }}</p>
                        <p class="text-green-100 text-xs mt-2">
                            {{ $inProgressTasks }} กำลังทำ • {{ $completedTasks }} เสร็จแล้ว
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Todo Tasks -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium mb-1">งานที่ต้องทำ</p>
                        <p class="text-4xl font-bold">{{ $todoTasks }}</p>
                        <p class="text-yellow-100 text-xs mt-2">
                            งานที่รอเริ่มต้น
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Overdue Tasks -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium mb-1">งานเกินกำหนด</p>
                        <p class="text-4xl font-bold">{{ $overdueTasks }}</p>
                        <p class="text-red-100 text-xs mt-2">
                            ต้องดำเนินการทันที
                        </p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="dash-grid grid grid-cols-1 gap-6">
            <!-- Task Status Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        การกระจายสถานะงาน
                    </h4>
                    <!-- <button
                        wire:click="$refresh"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg wire:loading.remove wire:target="$refresh" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg wire:loading wire:target="$refresh" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="$refresh">รีเฟรช</span>
                        <span wire:loading wire:target="$refresh">กำลังโหลด...</span>
                    </button> -->
                </div>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="taskStatusChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                        <p class="text-slate-600 mt-1">Todo: {{ $todoTasks }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                        <p class="text-slate-600 mt-1">In Progress: {{ $inProgressTasks }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                        <p class="text-slate-600 mt-1">Completed: {{ $completedTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Projects -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b">
                    <h4 class="font-bold text-slate-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        โปรเจกต์ล่าสุด
                    </h4>
                </div>
                <div class="divide-y max-h-96 overflow-y-auto">
                    @forelse($recentProjects as $project)
                        <div class="px-6 py-4 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-slate-900 truncate">{{ $project->name }}</h5>
                                    <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ Str::limit($project->description, 80) }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $project->updated_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                    @if($project->status === 'active') bg-green-100 text-green-800
                                    @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                    @elseif($project->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-slate-100 text-slate-800
                                    @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p>ยังไม่มีโปรเจกต์</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b">
                    <h4 class="font-bold text-slate-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        งานล่าสุด
                    </h4>
                </div>
                <div class="divide-y max-h-96 overflow-y-auto">
                    @forelse($recentTasks as $task)
                        <div class="px-6 py-4 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-slate-900 truncate">{{ $task->title }}</h5>
                                    <p class="text-xs text-slate-500 mt-1">{{ $task->project->name }}</p>
                                    @if($task->due_date)
                                        <p class="text-xs mt-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 font-medium' : 'text-slate-400' }}">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $task->due_date->format('M d, Y') }}
                                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                                (เกินกำหนด)
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                    @if($task->status === 'completed') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-slate-100 text-slate-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <p>ยังไม่มีงาน</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    @elseif(auth()->user()->role === 'customer')
        <!-- Customer Dashboard -->
        <div class="flex items-center justify-between">
            <div>
                <h3 class="dash-title text-3xl font-bold text-slate-900">สวัสดี, {{ auth()->user()->name }}!</h3>
                <p class="text-sm text-slate-600 mt-1">ภาพรวมโปรเจกต์ของคุณ</p>
            </div>
            <div class="text-sm text-slate-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="dash-grid grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Projects -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">โปรเจกต์ทั้งหมด</p>
                        <p class="text-4xl font-bold">{{ $totalProjects }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">กำลังดำเนินการ</p>
                        <p class="text-4xl font-bold">{{ $activeProjects }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Projects -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium mb-1">เสร็จสมบูรณ์</p>
                        <p class="text-4xl font-bold">{{ $completedProjects }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Projects -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium mb-1">รอดำเนินการ</p>
                        <p class="text-4xl font-bold">{{ $pendingProjects }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="dash-grid grid grid-cols-1 gap-6">
            <!-- Project Status Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h4 class="font-bold text-slate-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    สถานะโปรเจกต์
                </h4>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="projectStatusChart"></canvas>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2 text-xs">
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                        <p class="text-slate-600 mt-1">Active: {{ $activeProjects }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                        <p class="text-slate-600 mt-1">Completed: {{ $completedProjects }}</p>
                    </div>
                    <div class="text-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                        <p class="text-slate-600 mt-1">Pending: {{ $pendingProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Projects -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-b">
                <h4 class="font-bold text-slate-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    โปรเจกต์ของคุณ
                </h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                @forelse($recentProjects as $project)
                    <div class="border border-slate-200 rounded-lg p-5 hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-3">
                            <h5 class="font-bold text-slate-900 text-lg">{{ $project->name }}</h5>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                @if($project->status === 'active') bg-green-100 text-green-800
                                @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                @elseif($project->status === 'cancelled') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-3">{{ $project->description }}</p>
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span>{{ $project->updated_at->diffForHumans() }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg">ยังไม่มีโปรเจกต์ที่ได้รับมอบหมาย</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

<script>
    let charts = {};

    function destroyAllCharts() {
        Object.keys(charts).forEach(key => {
            if (charts[key]) {
                charts[key].destroy();
                delete charts[key];
            }
        });
    }

    document.addEventListener('livewire:load', function () {
        setTimeout(() => initCharts(), 100);
    });

    // For Livewire v3
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => initCharts(), 100);
    });

    // Listen for Livewire updates
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('effect', ({ succeed }) => {
            succeed(() => {
                destroyAllCharts();
                setTimeout(() => initCharts(), 100);
            });
        });
    }

    function initCharts() {
        @if(auth()->user()->role === 'admin')
            initAdminCharts();
        @elseif(auth()->user()->role === 'freelance')
            initFreelanceCharts();
        @elseif(auth()->user()->role === 'customer')
            initCustomerCharts();
        @endif
    }

    function initAdminCharts() {
        // User Role Distribution Chart
        const userRoleCtx = document.getElementById('userRoleChart');
        if (userRoleCtx && userRoleCtx.offsetParent !== null) {
            const adminUsers = {{ $adminUsers ?? 0 }};
            const freelanceUsers = {{ $freelanceUsers ?? 0 }};
            const customerUsers = {{ $customerUsers ?? 0 }};
            const totalUsers = adminUsers + freelanceUsers + customerUsers;

            if (totalUsers > 0) {
                charts.userRole = new Chart(userRoleCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Freelance', 'Customer'],
                        datasets: [{
                            data: [adminUsers, freelanceUsers, customerUsers],
                            backgroundColor: ['#EF4444', '#3B82F6', '#10B981'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 10,
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Project Status Chart
        const projectStatusCtx = document.getElementById('projectStatusChart');
        if (projectStatusCtx && projectStatusCtx.offsetParent !== null) {
            const activeProjects = {{ $activeProjects ?? 0 }};
            const completedProjects = {{ $completedProjects ?? 0 }};
            const pendingProjects = {{ $pendingProjects ?? 0 }};
            const totalProjects = activeProjects + completedProjects + pendingProjects;

            if (totalProjects > 0) {
                charts.projectStatus = new Chart(projectStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Active', 'Completed', 'Pending'],
                        datasets: [{
                            data: [activeProjects, completedProjects, pendingProjects],
                            backgroundColor: ['#10B981', '#3B82F6', '#F59E0B'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 10,
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    }

    function initFreelanceCharts() {
        // Task Status Chart
        const taskStatusCtx = document.getElementById('taskStatusChart');
        if (taskStatusCtx && taskStatusCtx.offsetParent !== null) {
            const todoTasks = {{ $todoTasks ?? 0 }};
            const inProgressTasks = {{ $inProgressTasks ?? 0 }};
            const completedTasks = {{ $completedTasks ?? 0 }};
            const totalTasks = todoTasks + inProgressTasks + completedTasks;

            if (totalTasks > 0) {
                charts.taskStatus = new Chart(taskStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Todo', 'In Progress', 'Completed'],
                        datasets: [{
                            data: [todoTasks, inProgressTasks, completedTasks],
                            backgroundColor: ['#F59E0B', '#3B82F6', '#10B981'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 10,
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    }

    function initCustomerCharts() {
        // Project Status Chart
        const projectStatusCtx = document.getElementById('projectStatusChart');
        if (projectStatusCtx && projectStatusCtx.offsetParent !== null) {
            const activeProjects = {{ $activeProjects ?? 0 }};
            const completedProjects = {{ $completedProjects ?? 0 }};
            const pendingProjects = {{ $pendingProjects ?? 0 }};
            const totalProjects = activeProjects + completedProjects + pendingProjects;

            if (totalProjects > 0) {
                charts.projectStatus = new Chart(projectStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Active', 'Completed', 'Pending'],
                        datasets: [{
                            data: [activeProjects, completedProjects, pendingProjects],
                            backgroundColor: ['#10B981', '#3B82F6', '#F59E0B'],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 12 },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                padding: 10,
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.parsed || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': ' + value + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    }
</script>
