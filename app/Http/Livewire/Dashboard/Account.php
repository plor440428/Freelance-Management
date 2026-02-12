<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\File;

class Account extends Component
{
    use WithFileUploads, WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $confirmingDeleteId = null;
    public $showSubscriptionModal = false;
    public $viewingUserId = null;

    // Filter properties
    public $search = '';
    public $filterRole = '';
    public $filterDate = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    // Form fields
    public $editingUserId = null;
    public $name;
    public $email;
    public $role = 'customer';
    public $password;
    public $password_confirmation;
    public $profile_image;

    protected $queryString = ['search', 'filterRole', 'filterDate', 'sortBy', 'sortDirection'];

    public function mount()
    {
        // Prevent customers from accessing account management
        if (Auth::user()->role === 'customer') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'filterRole', 'filterDate', 'sortBy', 'sortDirection'])) {
            $this->resetPage();
        }
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|min:3',
            'role' => 'required|in:admin,freelance,customer',
            'profile_image' => 'nullable|image|max:2048',
        ];

        if ($this->editingUserId) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->editingUserId;
            $rules['password'] = 'nullable|string|min:6|confirmed';
        } else {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    public function createUser()
    {
        // Prevent customers from creating users
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        try {
            $this->validate();

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'password' => Hash::make($this->password),
                'is_approved' => true, // Auto-approve admin-created users
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            if ($this->profile_image) {
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $this->profile_image->extension();
                $path = $this->profile_image->storeAs('profiles', $filename, 'public');

                File::create([
                    'module_name' => 'user',
                    'module_id' => $user->id,
                    'file_name' => $this->profile_image->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => 'image',
                    'mime_type' => $this->profile_image->getMimeType(),
                    'file_size' => $this->profile_image->getSize(),
                ]);

                $user->profile_image_path = $path;
                $user->save();
            }

            $this->dispatch('notify', message: 'User created successfully!', type: 'success');
            $this->resetForm();
            $this->showCreateModal = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to create user. ' . $e->getMessage(), type: 'error');
        }
    }

    public function edit($id)
    {
        // Prevent customers from editing users
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = null;
        $this->password_confirmation = null;
        $this->profile_image = null;
        $this->showEditModal = true;
    }

    public function updateUser()
    {
        // Prevent customers from updating users
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        try {
            $this->validate();

            $user = User::findOrFail($this->editingUserId);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->role = $this->role;

            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }

            if ($this->profile_image) {
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $this->profile_image->extension();
                $path = $this->profile_image->storeAs('profiles', $filename, 'public');

                File::create([
                    'module_name' => 'user',
                    'module_id' => $user->id,
                    'file_name' => $this->profile_image->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => 'image',
                    'mime_type' => $this->profile_image->getMimeType(),
                    'file_size' => $this->profile_image->getSize(),
                ]);

                $user->profile_image_path = $path;
            }

            $user->save();

            $this->dispatch('notify', message: 'User updated successfully!', type: 'success');
            $this->resetForm();
            $this->showEditModal = false;
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update user. ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Prevent customers from deleting users
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        $this->confirmingDeleteId = $id;
    }

    public function deleteUser($id)
    {
        // Prevent customers from deleting users
        if (Auth::user()->role === 'customer') {
            $this->dispatch('notify', message: 'Unauthorized action.', type: 'error');
            return;
        }

        try {
            $user = User::findOrFail($id);

            // Prevent deleting self
            if ($user->id === Auth::id()) {
                $this->dispatch('notify', message: 'You cannot delete your own account.', type: 'warning');
                $this->confirmingDeleteId = null;
                return;
            }

            $user->delete();
            $this->dispatch('notify', message: 'User deleted successfully!', type: 'success');
            $this->confirmingDeleteId = null;
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to delete user. ' . $e->getMessage(), type: 'error');
            $this->confirmingDeleteId = null;
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterRole = '';
        $this->filterDate = '';
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    protected function resetForm()
    {
        $this->editingUserId = null;
        $this->name = null;
        $this->email = null;
        $this->role = 'customer';
        $this->password = null;
        $this->password_confirmation = null;
        $this->profile_image = null;
    }

    public function viewSubscription($userId)
    {
        $this->viewingUserId = $userId;
        $this->showSubscriptionModal = true;
    }

    public function closeSubscriptionModal()
    {
        $this->showSubscriptionModal = false;
        $this->viewingUserId = null;
    }

    public function render()
    {
        $query = User::query();

        // Only show approved users
        $query->where('is_approved', true);

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Role filter
        if ($this->filterRole) {
            $query->where('role', $this->filterRole);
        }

        // Date filter
        if ($this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Get viewing user details if modal is open
        $viewingUser = null;
        if ($this->showSubscriptionModal && $this->viewingUserId) {
            $viewingUser = User::with(['paymentProofs' => function($q) {
                $q->latest();
            }])->find($this->viewingUserId);
        }

        return view('livewire.dashboard.account', [
            'users' => $query->paginate(10),
            'viewingUser' => $viewingUser,
        ]);
    }
}
