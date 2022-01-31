<?php

namespace App\Observers;

use App\Models\Order;
use App\Observers\Traits\GroupTrait;

class OrderObserver
{

    use GroupTrait;

    /**
     * Handle the order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        $this->before($order);
    }

    public function created(Order $order)
    {
        // $qty = data_get(request(), 'serverMemo.data.qty');
        // if(!$qty){
        //     \DB::rollback();
        //     return false;
        // }
        // $order->users()->attach(auth()->id(), compact('qty'));
        // session()->flash('success', 'Заказ успешно создан');
    }

    public function updating(Order $order)
    {
        $item = itemRepository()->where('sid', $order->sid);
        $order->price = $item['price'];
        $this->before($order);
    }

    public function saving(Order $order)
    {
        $this->before($order);
    }
}
