<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Project;

class Tasks extends Component
{
    use WithPagination;

    public $selectedTask = null;
    public $showTaskDetail = false;
    public $selectedProject = null;
    public $showProjectDetail = false;
    public $filterStatus = 'all';
    public $filterPriority = 'all';
    public $searchTerm = '';
    public $openAccordions = [];
    public $projectStatusFilters = []; // ['project_id' => 'status']

    public function mount()
    {
        // Prevent customers from accessing tasks page
        if (Auth::user()->role === 'customer') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function viewTask($taskId)
    {
        $this->selectedTask = Task::with(['project', 'assignee'])->find($taskId);
        $this->showTaskDetail = true;
    }

    public function closeTaskDetail()
    {
        $this->showTaskDetail = false;
        $this->selectedTask = null;
    }

    public function viewProject($projectId)
    {
        $this->selectedProject = Project::with(['creator', 'freelance', 'customers', 'managers'])->find($projectId);
        $this->showProjectDetail = true;
    }

    public function closeProjectDetail()
    {
        $this->showProjectDetail = false;
        $this->selectedProject = null;
    }

    public function toggleAccordion($projectId)
    {
        if (in_array($projectId, $this->openAccordions)) {
            $this->openAccordions = array_diff($this->openAccordions, [$projectId]);
        } else {
            $this->openAccordions[] = $projectId;
        }
    }

    public function updateTaskStatus($taskId, $status)
    {
        // Prevent customers from updating task status
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        $task = Task::find($taskId);
        if ($task) {
            $task->update(['status' => $status]);
            $this->dispatch('notify', message: 'Task status updated!', type: 'success');

            // Refresh selected task if viewing details
            if ($this->selectedTask && $this->selectedTask->id == $taskId) {
                $this->selectedTask = Task::with(['project', 'assignee'])->find($taskId);
            }
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Get tasks based on user role
        $tasksQuery = Task::with(['project', 'assignee', 'creator']);

        // Admin sees all tasks, others see only assigned or created tasks
        if ($user->role !== 'admin') {
            $tasksQuery->whereHas('project', function($q) {
                $q->where('status', 'active');
            });
            $tasksQuery->where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            });
        }

        // Apply status filter
        if ($this->filterStatus !== 'all') {
            $tasksQuery->where('status', $this->filterStatus);
        }

        // Apply priority filter
        if ($this->filterPriority !== 'all') {
            $tasksQuery->where('priority', $this->filterPriority);
        }

        // Apply search
        if ($this->searchTerm) {
            $tasksQuery->where(function($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $tasks = $tasksQuery->orderBy('due_date')->get();

        // Group tasks by project
        $projectGroups = $tasks->groupBy('project_id')->map(function($projectTasks, $projectId) {
            $project = $projectTasks->first()->project;

            // Apply project-specific status filter if exists
            $filteredTasks = $projectTasks;
            if (isset($this->projectStatusFilters[$projectId]) && $this->projectStatusFilters[$projectId] !== 'all') {
                $filteredTasks = $projectTasks->where('status', $this->projectStatusFilters[$projectId]);
            }

            return [
                'project' => $project,
                'tasks' => $filteredTasks,
                'allTasks' => $projectTasks, // Keep all tasks for stats
                'stats' => [
                    'total' => $projectTasks->count(),
                    'todo' => $projectTasks->where('status', 'todo')->count(),
                    'in_progress' => $projectTasks->where('status', 'in_progress')->count(),
                    'completed' => $projectTasks->where('status', 'completed')->count(),
                ]
            ];
        });

        return view('livewire.dashboard.tasks', [
            'tasks' => $tasks,
            'projectGroups' => $projectGroups,
        ]);
    }
}
