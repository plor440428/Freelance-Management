<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\File;
use App\Mail\ProjectStatusUpdatedNotification;
use App\Mail\ProjectManagerAssignedNotification;
use App\Mail\ProjectCustomerAssignedNotification;

class ProjectDetail extends Component
{
    use WithFileUploads;

    public $projectId;
    public $project;

    public $showEditModal = false;
    public $showEditCustomersModal = false;
    public $showUploadFilesModal = false;
    public $showEditFreelanceModal = false;
    public $showEditTeamMembersModal = false;
    public $confirmingDeleteId = null;
    public $confirmingDeleteTaskId = null;
    public $confirmingDeleteFileId = null;

    // Project form fields
    public $name;
    public $description;
    public $status;
    public $selectedCustomers = [];
    public $selectedFreelance = null;
    public $selectedTeamMembers = [];
    public $showCancelModal = false;
    public $cancelReason = '';
    public $pendingStatus = null;

    // File uploads
    public $uploadedFiles = [];

    // Task inline editing
    public $editingTaskId = null;
    public $addingNewTask = false;
    public $tasks = [];

    // Search fields for modals
    public $customerSearchQuery = '';
    public $teamMemberSearchQuery = '';
    public $freelanceSearchQuery = '';

    public function mount($id)
    {
        $this->projectId = $id;
        $this->loadProject();
    }

    public function backToProjects()
    {
        $this->dispatch('backToProjects');
    }

    public function loadProject()
    {
        $query = Project::with(['creator', 'freelance', 'customers', 'managers', 'tasks.assignee', 'files']);

        $user = Auth::user();

        // Apply role-based filtering
        if ($user->role === 'freelance') {
            $query->where(function ($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('freelance_id', $user->id);
            });
        } elseif ($user->role === 'customer') {
            $query->whereHas('customers', function ($q) use ($user) {
                $q->where('customer_id', $user->id);
            });
        }

        $this->project = $query->findOrFail($this->projectId);
    }

    protected function projectRules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,on_hold,cancelled',
            'selectedCustomers' => 'array',
        ];
    }

    protected function taskRules()
    {
        return [
            'taskTitle' => 'required|string|min:3|max:255',
            'taskDescription' => 'nullable|string',
            'taskStatus' => 'required|in:todo,in_progress,completed',
            'taskPriority' => 'required|in:low,medium,high',
            'taskAssignedTo' => 'nullable|exists:users,id',
            'taskDueDate' => 'nullable|date',
        ];
    }

    protected function canManageProject()
    {
        $user = Auth::user();

        // Admin can manage all projects
        if ($user->role === 'admin') {
            return true;
        }

        // Freelance can manage if they created it OR if they are assigned as freelance
        if ($user->role === 'freelance') {
            return $this->project->created_by === $user->id || $this->project->freelance_id === $user->id;
        }

        return false;
    }

    public function searchCustomers()
    {
        // Just trigger re-render with current search query
    }

    public function searchTeamMembers()
    {
        // Just trigger re-render with current search query
    }

    public function searchFreelance()
    {
        // Just trigger re-render with current search query
    }

    public function editProject()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to edit this project.', type: 'warning');
            return;
        }

        $this->name = $this->project->name;
        $this->description = $this->project->description;
        $this->status = $this->project->status;
        $this->cancelReason = $this->project->cancel_reason ?? '';
        $this->showEditModal = true;
    }

    public function editCustomers()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to edit this project.', type: 'warning');
            return;
        }

        $this->selectedCustomers = $this->project->customers->pluck('id')->toArray();
        $this->showEditCustomersModal = true;
    }

    public function updateStatus($newStatus)
    {
        try {
            // Check authorization
            if (!$this->canManageProject()) {
                $this->dispatch('notify', message: 'You do not have permission to edit this project.', type: 'warning');
                return;
            }

            // Validate status
            if (!in_array($newStatus, ['active', 'completed', 'on_hold', 'cancelled'])) {
                $this->dispatch('notify', message: 'Invalid status.', type: 'error');
                return;
            }

            if ($newStatus === 'cancelled') {
                $this->pendingStatus = $newStatus;
                $this->showCancelModal = true;
                return;
            }

            $oldStatus = $this->project->status;
            $this->project->update([
                'status' => $newStatus,
                'cancel_reason' => null,
                'cancelled_at' => null,
            ]);

            if ($oldStatus !== $newStatus) {
                $this->sendStatusUpdateEmails($oldStatus, $newStatus);
            }
            $this->dispatch('notify', message: 'Status updated successfully!', type: 'success');
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update status. ' . $e->getMessage(), type: 'error');
        }
    }

    public function updateProject()
    {
        try {
            $this->validate([
                'name' => 'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,completed,on_hold,cancelled',
                'cancelReason' => 'nullable|string|min:5|max:2000',
            ]);

            // Check authorization
            if (!$this->canManageProject()) {
                $this->dispatch('notify', message: 'You do not have permission to edit this project.', type: 'warning');
                return;
            }

            $oldStatus = $this->project->status;
            if ($this->status === 'cancelled' && trim((string) $this->cancelReason) === '') {
                $this->addError('cancelReason', 'กรุณาระบุเหตุผลการยกเลิก');
                return;
            }

            $this->project->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'cancel_reason' => $this->status === 'cancelled' ? $this->cancelReason : null,
                'cancelled_at' => $this->status === 'cancelled' ? now() : null,
            ]);

            if ($oldStatus !== $this->status) {
                $this->sendStatusUpdateEmails($oldStatus, $this->status);
            }

            $this->dispatch('notify', message: 'Project details updated successfully!', type: 'success');
            $this->showEditModal = false;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update project. ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmCancelStatus()
    {
        $this->validate([
            'cancelReason' => 'required|string|min:5|max:2000',
        ], [
            'cancelReason.required' => 'กรุณาระบุเหตุผลการยกเลิก',
            'cancelReason.min' => 'เหตุผลต้องมีอย่างน้อย 5 ตัวอักษร',
        ]);

        $oldStatus = $this->project->status;
        $this->project->update([
            'status' => 'cancelled',
            'cancel_reason' => $this->cancelReason,
            'cancelled_at' => now(),
        ]);

        if ($oldStatus !== 'cancelled') {
            $this->sendStatusUpdateEmails($oldStatus, 'cancelled');
        }

        $this->showCancelModal = false;
        $this->pendingStatus = null;
        $this->cancelReason = '';
        $this->dispatch('notify', message: 'Project cancelled successfully!', type: 'success');
        $this->loadProject();
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->pendingStatus = null;
        $this->cancelReason = '';
    }

    protected function sendStatusUpdateEmails(string $oldStatus, string $newStatus)
    {
        $project = $this->project->loadMissing('customers');
        foreach ($project->customers as $customer) {
            try {
                Mail::to($customer->email)->send(
                    new ProjectStatusUpdatedNotification($project, $customer, $oldStatus, $newStatus)
                );
            } catch (\Throwable $mailException) {
                \Log::error('Failed to send project status update email to ' . $customer->email . ': ' . $mailException->getMessage());
            }
        }
    }

    public function updateCustomers()
    {
        try {
            $this->validate([
                'selectedCustomers' => 'array',
            ]);

            // Check authorization
            if (!$this->canManageProject()) {
                $this->dispatch('notify', message: 'You do not have permission to edit this project.', type: 'warning');
                return;
            }

            // Get old customer IDs before syncing
            $oldCustomerIds = $this->project->customers->pluck('id')->toArray();

            // Update customers
            $this->project->customers()->sync($this->selectedCustomers);

            // Send email to newly added customers
            $newCustomerIds = array_diff($this->selectedCustomers, $oldCustomerIds);
            if (!empty($newCustomerIds)) {
                $newCustomers = User::whereIn('id', $newCustomerIds)->get();
                foreach ($newCustomers as $customer) {
                    try {
                        Mail::to($customer->email)->send(new ProjectCustomerAssignedNotification($this->project, $customer));
                    } catch (\Throwable $e) {
                        \Log::error('Failed to send customer assignment email', [
                            'project_id' => $this->project->id,
                            'customer_id' => $customer->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            $this->dispatch('notify', message: 'Customers updated successfully!', type: 'success');
            $this->showEditCustomersModal = false;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update customers. ' . $e->getMessage(), type: 'error');
        }
    }

    public function editTeamMembers()
    {
        // Check authorization - admin, creator, or assigned freelance
        $user = Auth::user();
        if ($user->role !== 'admin' && $this->project->created_by !== $user->id && $this->project->freelance_id !== $user->id) {
            $this->dispatch('notify', message: 'You do not have permission to manage team members.', type: 'warning');
            return;
        }

        $this->selectedTeamMembers = $this->project->managers->pluck('id')->toArray();
        $this->showEditTeamMembersModal = true;
    }

    public function updateTeamMembers()
    {
        try {
            $this->validate([
                'selectedTeamMembers' => 'array',
            ]);

            // Check authorization - admin, creator, or assigned freelance
            $user = Auth::user();
            if ($user->role !== 'admin' && $this->project->created_by !== $user->id && $this->project->freelance_id !== $user->id) {
                $this->dispatch('notify', message: 'You do not have permission to manage team members.', type: 'warning');
                return;
            }

            // Get old team member IDs before syncing
            $oldTeamMemberIds = $this->project->managers->pluck('id')->toArray();

            // Update team members
            $this->project->managers()->sync($this->selectedTeamMembers);

            // Send email to newly added team members
            $newTeamMemberIds = array_diff($this->selectedTeamMembers, $oldTeamMemberIds);
            if (!empty($newTeamMemberIds)) {
                $newTeamMembers = User::whereIn('id', $newTeamMemberIds)->get();
                foreach ($newTeamMembers as $member) {
                    try {
                        Mail::to($member->email)->send(new ProjectManagerAssignedNotification($this->project, $member));
                    } catch (\Throwable $e) {
                        \Log::error('Failed to send team member assignment email', [
                            'project_id' => $this->project->id,
                            'member_id' => $member->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            $this->dispatch('notify', message: 'Team members updated successfully!', type: 'success');
            $this->showEditTeamMembersModal = false;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update team members. ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDelete()
    {
        $this->confirmingDeleteId = $this->project->id;
    }

    public function deleteProject()
    {
        try {
            // Check authorization - only admin or creator can delete
            $user = Auth::user();
            if ($user->role !== 'admin' && $this->project->created_by !== $user->id) {
                $this->dispatch('notify', message: 'Only admin or project creator can delete this project.', type: 'warning');
                $this->confirmingDeleteId = null;
                return;
            }

            $this->project->delete();
            $this->dispatch('notify', message: 'Project deleted successfully!', type: 'success');
            return redirect()->route('dashboard.projects');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to delete project. ' . $e->getMessage(), type: 'error');
            $this->confirmingDeleteId = null;
        }
    }

    public function addNewTask()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to add tasks to this project.', type: 'warning');
            return;
        }

        // Initialize tasks array for the new task so Livewire bindings work
        $this->tasks = [];
        $this->tasks[0] = [
            'title' => '',
            'description' => '',
            'status' => 'todo',
            'priority' => 'medium',
            'assigned_to' => null,
            'due_date' => null,
        ];

        $this->addingNewTask = true;
        $this->editingTaskId = null;
    }

    public function saveNewTask($index)
    {
        try {
            // Validate nested task fields
            $this->validate([
                'tasks.*.title' => 'required|string|min:1|max:255',
                'tasks.*.description' => 'nullable|string',
                'tasks.*.status' => 'required|in:todo,in_progress,completed',
                'tasks.*.priority' => 'required|in:low,medium,high',
                'tasks.*.assigned_to' => 'nullable|exists:users,id',
                'tasks.*.due_date' => 'nullable|date',
            ]);

            $task = $this->tasks[$index] ?? [];

            // Authorization
            if (!$this->canManageProject()) {
                $this->dispatch('notify', message: 'You do not have permission to add tasks to this project.', type: 'warning');
                return;
            }

            // Normalize assigned_to
            $assignedTo = $task['assigned_to'] ?? null;
            if ($assignedTo === '') {
                $assignedTo = null;
            }

            Task::create([
                'project_id' => $this->project->id,
                'title' => $task['title'],
                'description' => $task['description'] ?? null,
                'status' => $task['status'] ?? 'todo',
                'priority' => $task['priority'] ?? 'medium',
                'assigned_to' => $assignedTo,
                'created_by' => auth()->id(),
                'due_date' => $task['due_date'] ?? null,
            ]);

            $this->dispatch('notify', message: 'Task created successfully!', type: 'success');
            $this->addingNewTask = false;
            $this->tasks = [];
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to create task. ' . $e->getMessage(), type: 'error');
        }
    }

    public function cancelNewTask()
    {
        $this->addingNewTask = false;
        $this->tasks = [];
    }

    public function editTask($taskId)
    {
        $this->editingTaskId = $taskId;
        $this->addingNewTask = false;

        // Populate the tasks array with current values for editing so bindings work
        $this->tasks = [];
        foreach ($this->project->tasks as $index => $t) {
            if ($t->id == $taskId) {
                $this->tasks[$index] = [
                    'title' => $t->title,
                    'description' => $t->description,
                    'status' => $t->status,
                    'priority' => $t->priority,
                    'assigned_to' => $t->assigned_to,
                    'due_date' => $t->due_date?->format('Y-m-d'),
                ];
                break;
            }
        }
    }

    public function updateTaskField($taskId, $field, $value)
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to edit tasks.', type: 'warning');
            return;
        }

        try {
            $task = Task::findOrFail($taskId);
            $task->update([$field => $value]);
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update task.', type: 'error');
        }
    }

    public function saveTask($taskId)
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to edit tasks.', type: 'warning');
            return;
        }

        try {
            // Find the task in the tasks array
            $taskIndex = null;
            foreach ($this->project->tasks as $index => $task) {
                if ($task->id == $taskId) {
                    $taskIndex = $index;
                    break;
                }
            }

            if ($taskIndex === null || !isset($this->tasks[$taskIndex])) {
                $this->dispatch('notify', message: 'Task not found.', type: 'error');
                return;
            }

            // Validate nested task fields for editing
            $this->validate([
                'tasks.*.title' => 'required|string|min:1|max:255',
                'tasks.*.description' => 'nullable|string',
                'tasks.*.status' => 'required|in:todo,in_progress,completed',
                'tasks.*.priority' => 'required|in:low,medium,high',
                'tasks.*.assigned_to' => 'nullable|exists:users,id',
                'tasks.*.due_date' => 'nullable|date',
            ]);

            // Validate task data
            $taskData = $this->tasks[$taskIndex];

            // Update the task
            $task = Task::findOrFail($taskId);

            $assignedTo = $taskData['assigned_to'] ?? null;
            if ($assignedTo === '') {
                $assignedTo = null;
            }

            $task->update([
                'title' => $taskData['title'] ?? $task->title,
                'description' => $taskData['description'] ?? $task->description,
                'status' => $taskData['status'] ?? $task->status,
                'priority' => $taskData['priority'] ?? $task->priority,
                'assigned_to' => $assignedTo,
                'due_date' => $taskData['due_date'] ?? $task->due_date,
            ]);

            $this->editingTaskId = null;
            $this->tasks = [];
            $this->dispatch('notify', message: 'Task updated successfully!', type: 'success');
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to save task. ' . $e->getMessage(), type: 'error');
        }
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->loadProject();
    }

    public function confirmDeleteTask($taskId)
    {
        $this->confirmingDeleteTaskId = $taskId;
    }

    public function deleteTask()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to delete tasks.', type: 'warning');
            return;
        }

        try {
            $task = Task::findOrFail($this->confirmingDeleteTaskId);
            $task->delete();

            $this->dispatch('notify', message: 'Task deleted successfully!', type: 'success');
            $this->confirmingDeleteTaskId = null;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to delete task. ' . $e->getMessage(), type: 'error');
            $this->confirmingDeleteTaskId = null;
        }
    }

    public function updatedUploadedFiles()
    {
        // Auto upload when files are selected
        $this->uploadFiles();
    }

    public function uploadFiles()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to upload files.', type: 'warning');
            return;
        }

        try {
            // Check authorization
            if (!$this->canManageProject()) {
                $this->dispatch('notify', message: 'You do not have permission to manage files for this project.', type: 'warning');
                $this->uploadedFiles = [];
                return;
            }

            // Validate files exist
            if (empty($this->uploadedFiles)) {
                return; // Silent return for empty selection
            }

            // Ensure uploadedFiles is array
            $files = is_array($this->uploadedFiles) ? $this->uploadedFiles : [$this->uploadedFiles];

            // Check file limit
            $currentFilesCount = $this->project->files()->count();
            $newFilesCount = count($files);

            if ($currentFilesCount + $newFilesCount > 5) {
                $this->dispatch('notify', message: 'Cannot upload. Maximum 5 files per project. Currently ' . $currentFilesCount . ' files.', type: 'error');
                $this->uploadedFiles = [];
                return;
            }

            // Validate each file
            $this->validate([
                'uploadedFiles' => 'required',
                'uploadedFiles.*' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt,zip,rar,webp|max:10240',
            ]);

            $uploadedCount = 0;
            foreach ($files as $file) {
                if ($file && is_object($file)) {
                    $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('projects', $fileName, 'public');

                    File::create([
                        'module_name' => 'Project',
                        'module_id' => $this->project->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $filePath,
                        'file_type' => $file->extension(),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                    $uploadedCount++;
                }
            }

            $this->dispatch('notify', message: $uploadedCount . ' file(s) uploaded successfully!', type: 'success');
            $this->uploadedFiles = [];
            $this->loadProject();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', message: 'Invalid file. Please check file type and size (max 10MB).', type: 'error');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to upload files. ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDeleteFile($fileId)
    {
        $this->confirmingDeleteFileId = $fileId;
    }

    public function deleteFile()
    {
        // Check authorization
        if (!$this->canManageProject()) {
            $this->dispatch('notify', message: 'You do not have permission to delete files.', type: 'warning');
            return;
        }

        try {
            $file = File::findOrFail($this->confirmingDeleteFileId);

            // Delete physical file
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            $file->delete();

            $this->dispatch('notify', message: 'File deleted successfully!', type: 'success');
            $this->confirmingDeleteFileId = null;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to delete file. ' . $e->getMessage(), type: 'error');
            $this->confirmingDeleteFileId = null;
        }
    }

    public function editFreelance()
    {
        // Only admin can edit freelance
        if (Auth::user()->role !== 'admin') {
            $this->dispatch('notify', message: 'Only admin can assign freelance.', type: 'warning');
            return;
        }

        $this->selectedFreelance = $this->project->freelance_id;
        $this->showEditFreelanceModal = true;
    }

    public function updateFreelance()
    {
        try {
            // Only admin can edit freelance
            if (Auth::user()->role !== 'admin') {
                $this->dispatch('notify', message: 'Only admin can assign freelance.', type: 'warning');
                return;
            }

            $this->validate([
                'selectedFreelance' => 'nullable|exists:users,id',
            ]);

            // Verify that selected user is actually a freelance
            if ($this->selectedFreelance) {
                $freelance = User::find($this->selectedFreelance);
                if ($freelance->role !== 'freelance') {
                    $this->dispatch('notify', message: 'Selected user is not a freelance.', type: 'error');
                    return;
                }
                if (!$freelance->is_approved) {
                    $this->dispatch('notify', message: 'Selected freelance is not approved yet.', type: 'error');
                    return;
                }
            }

            $this->project->update([
                'freelance_id' => $this->selectedFreelance,
            ]);

            $this->dispatch('notify', message: 'Freelance updated successfully!', type: 'success');
            $this->showEditFreelanceModal = false;
            $this->loadProject();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update freelance. ' . $e->getMessage(), type: 'error');
        }
    }



    public function render()
    {
        // Get available team members with search query (exclude project owner/creator)
        $availableTeamMembers = User::where('role', 'freelance')
            ->where('is_approved', true)
            ->where('id', '!=', $this->project->created_by) // Exclude project creator
            ->where('id', '!=', $this->project->freelance_id) // Exclude freelancer if assigned
            ->when($this->teamMemberSearchQuery, function($q) {
                $q->where(function($query) {
                    $query->where('email', 'like', '%' . $this->teamMemberSearchQuery . '%')
                          ->orWhere('name', 'like', '%' . $this->teamMemberSearchQuery . '%');
                });
            })
            ->get();

        // Get customers with search query
        $customers = User::where('role', 'customer')
            ->where('is_approved', true)
            ->when($this->customerSearchQuery, function($q) {
                $q->where(function($query) {
                    $query->where('email', 'like', '%' . $this->customerSearchQuery . '%')
                          ->orWhere('name', 'like', '%' . $this->customerSearchQuery . '%');
                });
            })
            ->get();

        // Get freelances with search query
        $freelances = User::where('role', 'freelance')
            ->where('is_approved', true)
            ->when($this->freelanceSearchQuery, function($q) {
                $q->where(function($query) {
                    $query->where('email', 'like', '%' . $this->freelanceSearchQuery . '%')
                          ->orWhere('name', 'like', '%' . $this->freelanceSearchQuery . '%');
                });
            })
            ->get();

        // Get task assignees from project managers only
        $taskAssignees = $this->project->managers;

        return view('livewire.dashboard.project-detail', [
            'customers' => $customers,
            'users' => User::whereIn('role', ['admin', 'freelance', 'customer'])->where('is_approved', true)->get(),
            'freelances' => $freelances,
            'availableTeamMembers' => $availableTeamMembers,
            'taskAssignees' => $taskAssignees,
        ]);
    }
}
