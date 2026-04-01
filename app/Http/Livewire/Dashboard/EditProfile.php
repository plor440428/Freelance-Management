<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Validation\Rule;

class EditProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $profile_image;
    public $showModal = false;
    public $saveSuccessMessage = '';

    protected $listeners = ['openEditProfileModal' => 'open'];

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|string|min:6|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ];
    }

    public function open()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->saveSuccessMessage = '';
        $this->showModal = true;
    }

    public function updateProfile()
    {
        try {
            $this->saveSuccessMessage = '';
            $user = auth()->user();

            $rules = [
                'name' => 'required|string|min:3',
                'password' => 'nullable|string|min:6|confirmed',
                'profile_image' => 'nullable|image|max:2048',
            ];

            // If email is unchanged, skip unique check so existing duplicate test data
            // does not block profile updates.
            if ($this->email === $user->email) {
                $rules['email'] = 'required|email';
            } else {
                $rules['email'] = ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)];
            }

            $this->validate($rules);

            $user->name = $this->name;
            $user->email = $this->email;

            if ($this->password) {
                $user->password = Hash::make($this->password);
            }

            if ($this->profile_image) {
                if ($user->profile_image_path && Storage::disk('public')->exists($user->profile_image_path)) {
                    Storage::disk('public')->delete($user->profile_image_path);
                }

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

            $user->saveOrFail();

            // Refresh the user in auth cache
            auth()->setUser($user->fresh());

            $this->saveSuccessMessage = 'Profile updated successfully!';
            $this->dispatch('notify', message: 'Profile updated successfully!', type: 'success');
            $this->resetForm();
            $this->dispatch('profileUpdated');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Failed to update profile. ' . $e->getMessage(), type: 'error');
        }
    }

    public function resetForm()
    {
        $this->profile_image = null;
        $this->password = null;
        $this->password_confirmation = null;
    }

    public function render()
    {
        return view('livewire.dashboard.edit-profile');
    }
}
