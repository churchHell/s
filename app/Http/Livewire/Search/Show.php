<?php

namespace App\Http\Livewire\Search;

use App\Http\Livewire\Traits\Crud;
use App\Models\Group;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{

    use AuthorizesRequests, Crud;

    protected string $class = Order::class;

    public Group $group;
    public array $item;
    public int $itemKey;
    public string $qty = '';

    protected function rules()
    {
        return [
            'qty' => ['required', 'integer', 'min:1'],
            'item.sid' => 'unique:orders,sid,NULL,id,group_id,'.$this->group->id
        ];
    }

    protected function validationAttributes(){
        return [
            'item.sid' => __('sid')
        ];
    }

    public function store(): void
    {
        $this->authorize('create', Order::class);
        $validated = $this->validate();

        try{
            $item = itemRepository()->where('sid', $this->item['sid'])->toArray();
            \DB::beginTransaction();
            $order = $this->group->orders()->create($item);
            $order->users()->attach(id(), $validated);
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->addError('qty', $e->getMessage());
            return;
        }
        \DB::commit();
    }

    public function remove(): void
    {
        $this->emit('searchDelete', $this->itemKey);
    }

    public function render()
    {

        return view('livewire.search.show');
    }
}
