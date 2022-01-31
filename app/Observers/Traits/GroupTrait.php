<?php

namespace App\Observers\Traits;

use App\Models\Order;

trait GroupTrait
{

    private function before(Order $order): void
    {
        abort_if($order->group->isArchived(), 500, __('group.archived'));
    }

}