<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\Crud;
use Livewire\Component;

class Delete extends Component
{

    use Crud;

    public string $class;
    public int $row;
    public bool $confirm = false;

    protected $listeners = ['confirmYes', 'confirmNo'];

    public function delete(): void
    {
        $this->confirm = true;
    }

    public function confirmYes(): void
    {
        $deleted = $this->crudDelete($this->row);
        if ($deleted) {
            $this->emit('deleteDeleted');
        }
    }

    public function confirmNo(): void
    {
        $this->confirm = false;
    }

    public function render()
    {
        return view('livewire.delete');
    }
}
