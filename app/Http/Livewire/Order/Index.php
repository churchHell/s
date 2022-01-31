<?php

namespace App\Http\Livewire\Order;

use App\Models\{Group, Order};
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{

    use AuthorizesRequests;

    public int $groupId;
    public array $filters = [
        'title' => '',
        'user' => '',
    ];
    public int $editPivotId = 0;
    public int $createOrderId = 0;

    protected $listeners = ['edit', 'create', 'deleteDeleted' => 'render'];

    public function edit(int $id = 0): void
    {
        $this->editPivotId = $id;
    }

    public function create(int $id = 0): void
    {
        $this->createOrderId = $id;
    }

    public function updatePrice(int $id) : void
    {
        $order = Order::findOrFail($id);
        $this->authorize('refresh', $order);

        $item = itemRepository()->where('sid', $order->sid);
        $this->result($order->update(['price' => $item->get('price'), 'updated_at' => now()]));
    }

    public function render()
    {
        $orders = Order::with('users')
            ->where('name', 'like', '%'.$this->filters['title'].'%')
            ->whereHas('users', function($query){
                $query->where(DB::raw('concat(name," ",surname)'), 'like', '%'.$this->filters['user'].'%');
            })->whereGroupId($this->groupId)->get();
        return view('livewire.order.index', compact('orders'));
    }
}
