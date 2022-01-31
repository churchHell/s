<?php

namespace App\Models\Pivots;

use App\Casts\Price;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderUser extends Pivot
{
    use HasFactory;

    protected $fillable = ['user_id', 'qty', 'delivery', 'updated_at'];
    protected $casts = ['delivery' => Price::class];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
