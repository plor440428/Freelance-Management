<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\On;

class Shell extends Component
{
    public $active = 'home';

    public function mount()
    {
        $this->active = 'home';
    }

    #[On('setActive')]
    public function setActive($name)
    {
        $this->active = $name;
    }

    public function render()
    {
        return view('livewire.dashboard.shell');
    }
}
