<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Work extends Model
{

    protected $fillable = ['user_id', 'job', 'current', 'max', 'ended_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function start(string $job, int $max): self
    {
        return $this->create(['user_id' => auth()->id(), 'job' => $job, 'max' => $max]);
    }

    public function end(): bool
    {
        return $this->update(['ended_at' => now()]);
    }

    public function iterate(int $add = 1): bool
    {
        return $this->update(['current' => $this->current + $add]);
    }

    public function actual(): Collection
    {
        return $this->whereNull('ended_at', '>=', Carbon::now()->subHours(24))->get();
    }

    public function inProcess(): Collection
    {
        return $this->whereNull('ended_at')->get();
    }

    public function isInProcess(): bool
    {
        return $this->ended_at == null;
    }

}
