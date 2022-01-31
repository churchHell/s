<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Pivots\OrderUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{

    use AuthorizesRequests;

    public Order $order;
    public ?string $qty = null;

    protected array $rules = [
        'qty' => ['required', 'integer', 'min:1']
    ];

    public function store(): void
    {
        $this->authorize('create', $this->order);
        $validated = $this->validate();
        $this->order->users()->syncWithoutDetaching([id() => $validated]);
        $this->emit('joined');
    }

    public function render()
    {
        return view('livewire.order.create');
    }
}
