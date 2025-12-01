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

    public function render()
    {
        return view('livewire.dashboard.container');
    }
}
