<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Container extends Component
{
    public $active = 'home';
    public $projectDetailId = null;

    public function mount()
    {
        $path = trim((string) request()->path(), '/');

        if (preg_match('#^dashboard/projects/(\d+)$#', $path, $matches)) {
            $this->active = 'projects';
            $this->projectDetailId = (int) $matches[1];

            if (session()->has('notify_message')) {
                $this->dispatch('notify',
                    message: session()->pull('notify_message'),
                    type: session()->pull('notify_type', 'success')
                );
            }

            return;
        }

        $sectionMap = [
            'dashboard' => 'home',
            'dashboard/home' => 'home',
            'dashboard/projects' => 'projects',
            'dashboard/tasks' => 'tasks',
            'dashboard/account' => 'account',
            'dashboard/approve' => 'approve',
            'dashboard/settings' => 'settings',
        ];

        $this->active = $sectionMap[$path] ?? 'home';

        if (session()->has('notify_message')) {
            $this->dispatch('notify',
                message: session()->pull('notify_message'),
                type: session()->pull('notify_type', 'success')
            );
        }
    }

    public function setActive($name)
    {
        $this->active = $name;
        $this->projectDetailId = null;
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
            'settings' => ['admin', 'freelance', 'customer'],
        ];

        return in_array($userRole, $menuPermissions[$menuName] ?? []);
    }

    public function activeRouteName(): string
    {
        $routeMap = [
            'home' => 'dashboard.home',
            'projects' => 'dashboard.projects',
            'tasks' => 'dashboard.tasks',
            'account' => 'dashboard.account',
            'approve' => 'dashboard.approve',
            'settings' => 'dashboard.settings',
        ];

        return $routeMap[$this->active] ?? 'dashboard.home';
    }

    public function activeRouteParams(): array
    {
        if ($this->active !== 'projects') {
            return [];
        }

        return request()->only([
            'search',
            'filterStatus',
            'filterFreelance',
            'filterCustomer',
            'page',
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.container');
    }
}
