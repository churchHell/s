<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name'];
    public $timestamps = false;

    const USER = 1;
    const ADMIN = 2;
    const SUPER = 3;

    public function users(){
        return $this->hasMany(User::class);
    }

}
