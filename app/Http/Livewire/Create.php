<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\Crud;
use Livewire\Component;

class Create extends Component
{

    use Crud;

    public string $class;
    public array $fields;
    public array $rules;

    public function mount(array $rules): void
    {
        $this->rules = array_keys_prepend($rules, 'fields');
    }

    public function store(): void
    {
        $validated = $this->validate()['fields'];
        $model = $this->crudStore($validated);
        if($model->exists){
            $this->emit('createStored', $model);
        }
    }

    public function render()
    {
        return view('livewire.create');
    }
}
