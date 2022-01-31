<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Confirm extends Component
{

    public function yes(): void
    {
        $this->emitUp('confirmYes');
    }

    public function no(): void
    {
        $this->emitUp('confirmNo');
    }
    
    public function render()
    {
        return view('livewire.confirm');
    }
}
