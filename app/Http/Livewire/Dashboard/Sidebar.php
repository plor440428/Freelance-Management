<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Sidebar extends Component
{
    public $active = 'home';

    public function setActive($name)
    {
        $this->active = $name;
        $this->dispatch('setActive', name: $name);
    }

    public function render()
    {
        return view('livewire.dashboard.sidebar');
    }
}
