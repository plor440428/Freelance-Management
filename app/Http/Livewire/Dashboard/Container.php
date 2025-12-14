<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Container extends Component
{
    public $active = 'home';

    public function setActive($name)
    {
        $this->active = $name;
    }

    public function canSeeMenu($menuName)
    {
        $userRole = auth()->user()->role;

        $menuPermissions = [
            'home' => ['admin', 'freelance', 'customer'],
            'projects' => ['admin', 'freelance', 'customer'],
            'tasks' => ['admin', 'freelance'],
            'account' => ['admin'],
            'approve' => ['admin'],
            'settings' => ['admin'],
        ];

        return in_array($userRole, $menuPermissions[$menuName] ?? []);
    }

    public function render()
    {
        return view('livewire.dashboard.container');
    }
}
