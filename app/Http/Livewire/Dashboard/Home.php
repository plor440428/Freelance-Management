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
        $data = [];

        if ($user->role === 'freelance') {
            // Projects where freelance is owner or assigned
            $projects = Project::where(function($q) use ($user) {
                $q->where('freelance_id', $user->id)
                  ->orWhere('created_by', $user->id)
                  ->orWhereHas('managers', function($q2) use ($user) {
                      $q2->where('user_id', $user->id);
                  });
            })->where('status', 'active')->get();

            $data['totalProjects'] = $projects->count();
            $data['activeProjects'] = $projects->where('status', 'active')->count();
            $data['completedProjects'] = Project::where(function($q) use ($user) {
                $q->where('freelance_id', $user->id)
                  ->orWhere('created_by', $user->id)
                  ->orWhereHas('managers', function($q2) use ($user) {
                      $q2->where('user_id', $user->id);
                  });
            })->where('status', 'completed')->count();

            // Tasks assigned to or created by freelance
            $tasks = Task::whereHas('project', function($q) {
                $q->where('status', 'active');
            })->where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            })->get();

            $data['totalTasks'] = $tasks->count();
            $data['todoTasks'] = $tasks->where('status', 'todo')->count();
            $data['inProgressTasks'] = $tasks->where('status', 'in_progress')->count();
            $data['completedTasks'] = $tasks->where('status', 'completed')->count();
            $data['overdueTasks'] = $tasks->filter(function($task) {
                return $task->due_date && $task->due_date->isPast() && $task->status !== 'completed';
            })->count();

            // Recent projects
            $data['recentProjects'] = $projects->sortByDesc('updated_at')->take(5);

            // Recent tasks
            $data['recentTasks'] = $tasks->sortByDesc('updated_at')->take(5);

        } elseif ($user->role === 'admin') {
            // Admin sees all data
            $data['totalProjects'] = Project::count();
            $data['activeProjects'] = Project::where('status', 'active')->count();
            $data['completedProjects'] = Project::where('status', 'completed')->count();
            $data['totalUsers'] = User::count();
            $data['freelanceUsers'] = User::where('role', 'freelance')->count();
            $data['customerUsers'] = User::where('role', 'customer')->count();
            $data['totalTasks'] = Task::count();
            $data['recentProjects'] = Project::orderBy('updated_at', 'desc')->take(5)->get();
        } elseif ($user->role === 'customer') {
            // Customer sees their projects
            $projects = Project::whereHas('customers', function($q) use ($user) {
                $q->where('customer_id', $user->id);
            })->get();

            $data['totalProjects'] = $projects->count();
            $data['activeProjects'] = $projects->where('status', 'active')->count();
            $data['completedProjects'] = $projects->where('status', 'completed')->count();
            $data['recentProjects'] = $projects->sortByDesc('updated_at')->take(5);
        }

        return view('livewire.dashboard.home', $data);
    }
}
