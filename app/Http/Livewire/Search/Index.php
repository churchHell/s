<?php

namespace App\Http\Livewire\Search;

use App\Http\Livewire\Traits\TryCatch;
use App\Models\Group;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{

    use AuthorizesRequests, TryCatch;

    public Group $group;
    public array $items = [];
    public string $sid = '';

    protected $listeners = [
        'searchDelete' => 'delete'
    ];

    protected function rules()
    {
        return [
            'sid' => ['required', 'integer', 'min:1', 'unique:orders,sid,NULL,id,group_id,'.$this->group->id]
        ];
    }

    public function search(): void
    {

        $this->authorize('create', Order::class);

        $this->validate();

        try {
            $item = itemRepository()->where('sid', $this->sid)->toArray();
            $this->items[$item['sid']] = $item;
        } catch (\Exception $e) {
            $this->addError('sid', $e->getMessage());
            return;
        }
        
    }

    public function delete(int $key): void
    {
        unset($this->items[$key]);
    }

    public function render()
    {   
        return view('livewire.search.index');
    }
}
