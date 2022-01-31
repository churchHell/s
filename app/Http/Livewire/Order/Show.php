<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Pivots\OrderUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Order $order;
    public ?int $editPivotId = null;
    public array $orderUserRules = ['qty'=>'required|integer|min:1'];

    protected $listeners = ['editUpdated' => 'modalClose', 'modalClose', 'joined'];

    public function modalClose(): void
    {
        $this->editPivotId = null;
    }

    public function joined(): void
    {
        $this->order->load('users');
    }

    public function updateDelivery(int $pivotId): void
    {
        $pivot = OrderUser::findOrFail($pivotId);
        $this->authorize('update', $pivot);
        $pivot->touch();
        $this->order->load('users');
    }

    public function updatePrice(): void
    {
        $this->authorize('update', $this->order);
        $this->order->touch();
    }

    public function render()
    {
        return view('livewire.order.show');
    }
}
