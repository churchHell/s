<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const ADDED = 1;
    public const NOT_ADDED = 2;
    public const LESS_QTY = 3;
    public const DIFF_QTY = 4;
    public const CHANGED = 5;

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
