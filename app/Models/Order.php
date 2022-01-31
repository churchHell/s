<?php

namespace App\Models;

use App\Casts\Price;
use App\Models\Pivots\OrderUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'pid', 'sid', 'name', 'url', 'img', 'price', 'min_qty', 'plural_name_format', 'currency', 'updated_at'];
    protected $guarder = ['created_at'];
    protected $casts = ['price' => Price::class];

    public function getMinToOrderAttribute($value)
    {
        return $this->min_qty . ' ' . $this->plural_name_format;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('id', 'qty', 'delivery')->withTimestamps()->using(OrderUser::class);
    }

    public function userPivot(User $user): OrderUser
    {
        try {
            return $this->users->find($user)->pivot;
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function cartStatus()
    {
        return $this->belongsTo(CartStatus::class);
    }

    public function qty(): int
    {
        return $this->users->sum('pivot.qty');
        return $this->users->reduce(fn ($carry, $item) => $carry + $item->pivot->qty, 0);
    }

    public function withData($key = 'qty')
    {
        $this->$key = $this->users->sum('pivot.qty');
        return $this;
        //        return $this->users->each( fn($user) => $this->$key = $user->sum('qty') );
    }
}
