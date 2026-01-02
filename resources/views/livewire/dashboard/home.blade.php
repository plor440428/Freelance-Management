<div class="space-y-6">
    @if(auth()->user()->role === 'freelance')
        <!-- Freelance Dashboard -->
        <div>
            <h3 class="text-2xl font-bold text-slate-900 mb-1">Welcome back, {{ auth()->user()->name }}!</h3>
            <p class="text-sm text-slate-600">Here's what's happening with your projects and tasks.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Projects -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Total Projects</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalProjects }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    {{ $activeProjects }} active • {{ $completedProjects }} completed
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Total Tasks</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $totalTasks }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    {{ $inProgressTasks }} in progress • {{ $completedTasks }} done
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Todo Tasks</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $todoTasks }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Tasks waiting to start
                </div>
            </div>

            <!-- Overdue Tasks -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Overdue Tasks</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $overdueTasks }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-slate-500">
                    Needs immediate attention
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Projects -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h4 class="font-semibold text-slate-900">Recent Projects</h4>
                </div>
                <div class="divide-y">
                    @forelse($recentProjects as $project)
                        <div class="px-6 py-4 hover:bg-slate-50">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h5 class="font-medium text-slate-900">{{ $project->name }}</h5>
                                    <p class="text-sm text-slate-500 mt-1">{{ Str::limit($project->description, 80) }}</p>
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    @if($project->status === 'active') bg-green-100 text-green-800
                                    @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-slate-100 text-slate-800
                                    @endif">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-slate-500">
                            <p>No projects yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h4 class="font-semibold text-slate-900">Recent Tasks</h4>
                </div>
                <div class="divide-y">
                    @forelse($recentTasks as $task)
                        <div class="px-6 py-4 hover:bg-slate-50">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h5 class="font-medium text-slate-900">{{ $task->title }}</h5>
                                    <p class="text-xs text-slate-500 mt-1">{{ $task->project->name }}</p>
                                    @if($task->due_date)
                                        <p class="text-xs mt-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600' : 'text-slate-500' }}">
                                            Due: {{ $task->due_date->format('M d, Y') }}
                                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                                (Overdue)
                                            @endif
                                        </p>
                                    @endif
                                </div>
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    @if($task->status === 'completed') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-slate-100 text-slate-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-slate-500">
                            <p>No tasks yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    @elseif(auth()->user()->role === 'admin')
        <!-- Admin Dashboard -->
        <div>
            <h3 class="text-2xl font-bold text-slate-900 mb-1">Admin Dashboard</h3>
            <p class="text-sm text-slate-600">System overview and statistics.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <p class="text-sm text-slate-600 mb-1">Total Projects</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalProjects }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $activeProjects }} active</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-sm text-slate-600 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $freelanceUsers }} freelance • {{ $customerUsers }} customer</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <p class="text-sm text-slate-600 mb-1">Total Tasks</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalTasks }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                <p class="text-sm text-slate-600 mb-1">Completed</p>
                <p class="text-3xl font-bold text-slate-900">{{ $completedProjects }}</p>
                <p class="text-xs text-slate-500 mt-2">Projects completed</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h4 class="font-semibold text-slate-900">Recent Projects</h4>
            </div>
            <div class="divide-y">
                @forelse($recentProjects as $project)
                    <div class="px-6 py-4 hover:bg-slate-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-medium text-slate-900">{{ $project->name }}</h5>
                                <p class="text-sm text-slate-500">Created by {{ $project->creator->name }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500">No projects</div>
                @endforelse
            </div>
        </div>

    @elseif(auth()->user()->role === 'customer')
        <!-- Customer Dashboard -->
        <div>
            <h3 class="text-2xl font-bold text-slate-900 mb-1">Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-sm text-slate-600">Your projects overview.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <p class="text-sm text-slate-600 mb-1">Total Projects</p>
                <p class="text-3xl font-bold text-slate-900">{{ $totalProjects }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <p class="text-sm text-slate-600 mb-1">Active Projects</p>
                <p class="text-3xl font-bold text-slate-900">{{ $activeProjects }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <p class="text-sm text-slate-600 mb-1">Completed</p>
                <p class="text-3xl font-bold text-slate-900">{{ $completedProjects }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h4 class="font-semibold text-slate-900">Your Projects</h4>
            </div>
            <div class="divide-y">
                @forelse($recentProjects as $project)
                    <div class="px-6 py-4 hover:bg-slate-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h5 class="font-medium text-slate-900">{{ $project->name }}</h5>
                                <p class="text-sm text-slate-500">{{ Str::limit($project->description, 100) }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500">No projects assigned</div>
                @endforelse
            </div>
        </div>
    @endif
</div>
