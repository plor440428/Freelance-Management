<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class Home extends Component
{
    public function render()
    {
        $user = Auth::user();
        $data = [
            'totalProjects' => 0,
            'activeProjects' => 0,
            'completedProjects' => 0,
            'pendingProjects' => 0,
            'totalTasks' => 0,
            'todoTasks' => 0,
            'inProgressTasks' => 0,
            'completedTasks' => 0,
            'recentProjects' => collect(),
            'recentTasks' => collect(),
        ];

        if ($user->role === 'freelance') {
            // Projects where freelance is project creator or freelance owner
            $allProjects = Project::where(function($q) use ($user) {
                $q->where('freelance_id', $user->id)
                  ->orWhere('created_by', $user->id);
            })->get();

            $projects = $allProjects->where('status', 'active');
            $data['totalProjects'] = $allProjects->count();
            $data['activeProjects'] = $projects->count();
            $data['completedProjects'] = $allProjects->where('status', 'completed')->count();
            $data['pendingProjects'] = $allProjects->where('status', 'pending')->count();

            // Tasks assigned to or created by freelance
            $allTasks = Task::where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            })->get();

            $data['totalTasks'] = $allTasks->count();
            $data['todoTasks'] = $allTasks->where('status', 'todo')->count();
            $data['inProgressTasks'] = $allTasks->where('status', 'in_progress')->count();
            $data['completedTasks'] = $allTasks->where('status', 'completed')->count();
            $data['overdueTasks'] = $allTasks->filter(function($task) {
                return $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
            })->count();

            // Recent projects
            $data['recentProjects'] = $allProjects->sortByDesc('updated_at')->take(5);

            // Recent tasks
            $data['recentTasks'] = $allTasks->sortByDesc('updated_at')->take(5);

        } elseif ($user->role === 'admin') {
            // Admin sees all data
            $allProjects = Project::all();
            $data['totalProjects'] = $allProjects->count();
            $data['activeProjects'] = $allProjects->where('status', 'active')->count();
            $data['completedProjects'] = $allProjects->where('status', 'completed')->count();
            $data['pendingProjects'] = $allProjects->where('status', 'pending')->count();

            // User statistics
            $allUsers = User::all();
            $data['totalUsers'] = $allUsers->count();
            $data['freelanceUsers'] = $allUsers->where('role', 'freelance')->count();
            $data['customerUsers'] = $allUsers->where('role', 'customer')->count();
            $data['adminUsers'] = $allUsers->where('role', 'admin')->count();
            $data['pendingApprovals'] = $allUsers->where('is_approved', false)->count();
            $data['approvedUsers'] = $allUsers->where('is_approved', true)->count();

            // Task statistics
            $allTasks = Task::all();
            $data['totalTasks'] = $allTasks->count();
            $data['todoTasks'] = $allTasks->where('status', 'todo')->count();
            $data['inProgressTasks'] = $allTasks->where('status', 'in_progress')->count();
            $data['completedTasks'] = $allTasks->where('status', 'completed')->count();

            $data['recentProjects'] = $allProjects->sortByDesc('updated_at')->take(5);

        } elseif ($user->role === 'customer') {
            // Customer sees their projects
            $projects = Project::whereHas('customers', function($q) use ($user) {
                $q->where('customer_id', $user->id);
            })->get();

            $data['totalProjects'] = $projects->count();
            $data['activeProjects'] = $projects->where('status', 'active')->count();
            $data['completedProjects'] = $projects->where('status', 'completed')->count();
            $data['pendingProjects'] = $projects->where('status', 'pending')->count();

            $data['recentProjects'] = $projects->sortByDesc('updated_at')->take(5);
        }

        return view('livewire.dashboard.home', $data);
    }
}
