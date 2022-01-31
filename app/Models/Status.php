<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name'];
    public $timestamps = false;

    public const ACTUAL = 1;
    public const ARCHIVED = 2;
    public const SUCCESS = 3;
    public const ERROR = 4;
    public const INFO = 5;

    public function isNew(): bool
    {
        return $this->slug == 'new';
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function actual(): Status
    {
        return $this->findOrFail(self::ACTUAL);
    }

    public function archived(): Status
    {
        return $this->findOrFail(self::ARCHIVED);
    }

    public function isArchived(): bool
    {
        return $this->id == self::ARCHIVED;
    }

}
