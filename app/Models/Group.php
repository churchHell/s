<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Builder, Model};

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'created_user_id', 'status_id', 'processed_at'];

    protected $casts = ['processed_at' => 'datetime'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function archived(): Builder
    {
        return $this->where('status_id', Status::ARCHIVED);
    }

    public function actual(): Builder
    {
        return $this->where('status_id', Status::ACTUAL);
    }

    public function isArchived(): bool
    {
        return $this->status_id == Status::ARCHIVED;
    }
}
