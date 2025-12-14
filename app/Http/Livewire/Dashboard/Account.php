<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\File;

class Account extends Component
{
    use WithFileUploads;

    public $users = [];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $confirmingDeleteId = null;

    // Form fields
    public $editingUserId = null;
    public $name;
    public $email;
    public $role = 'customer';
    public $password;
    public $password_confirmation;
    public $profile_image;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::orderBy('id', 'desc')->get();
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
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password),
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

        session()->flash('success', 'User created successfully.');
        $this->resetForm();
        $this->showCreateModal = false;
        $this->loadUsers();
    }

    public function edit($id)
    {
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

        session()->flash('success', 'User updated successfully.');
        $this->resetForm();
        $this->showEditModal = false;
        $this->loadUsers();
    }

    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot delete your own account.');
            $this->confirmingDeleteId = null;
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->confirmingDeleteId = null;
        $this->loadUsers();
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

    public function render()
    {
        return view('livewire.dashboard.account', ['users' => $this->users]);
    }
}
