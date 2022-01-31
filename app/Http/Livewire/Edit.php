<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Http\Livewire\Traits\Crud;

class Edit extends Component
{

    use Crud;

    public string $class;
    public int $row;
    public array $fields;
    public array $rules = [];
    public bool $vertical = true;
    public string $width = 'full';
    public string $size;
    public string $color = 'default';

    public string $styles = 'space-x-2';

    public function mount(array $rules): void
    {
        list($this->styles, $this->size) = Str::of($this->styles)->divideSizes();
        $this->rules = array_keys_prepend($rules, 'fields.');
    }

    public function update(): void
    {
        $validated = $this->validate($this->rules)['fields'];
        $updated = $this->crudUpdate($this->row, $validated);
        if ($updated) {
            session()->flush('success', 'Данные успешно обновлены');
            $this->emit('editUpdated');
        }
    }

    public function render()
    {
        return view('livewire.edit');
    }
}
