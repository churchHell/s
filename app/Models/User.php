<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, PasswordsCanResetPassword;

    protected $fillable = ['name', 'surname', 'phone', 'email', 'password', 'role_id', 'active', 'moderated', 'cart_email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function orders(){
        return $this->belongsToMany(Order::class)->withPivot('id', 'qty', 'delivery')->withTimestamps()->using(Pivots\OrderUser::class);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function getShortNameAttribute(): string
    {
        return ucfirst(strtolower($this->surname)) . ' ' . ucfirst(mb_substr($this->name, 0, 1)) . '.';
    }

    public function getFullNameAttribute(): string
    {
        return ucfirst(strtolower($this->surname)) . ' ' . ucfirst(strtolower($this->name));
    }

    public function isAdmin(): bool
    {
        return $this->role_id >= Role::ADMIN;
    }

    public function isSuper(): bool
    {
        return $this->role_id >= Role::SUPER;
    }

    public function hasRole(string $role): bool
    {
        return $this->role_id == constant(Role::class.'::'.strtoupper($role));
    }

    public function isActive(): bool
    {
        return $this->active == 1;
    }

    public function toggle(string $key) : bool
    {
        return $this->update([$key => !$this->$key]);
    }

}
