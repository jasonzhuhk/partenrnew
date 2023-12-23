<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Exercises extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'addtime' => 'datetime',
    ];


    /**
     * Checks if user is a super admin
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        if ($this->role == 'admin') {
            return true;
        }
    }

 
    /**
     * Checks if super admin exists
     *
     * @return integer
     */
    public function adminExists(): int
    {
        return self::where('role', 'admin')->count();
    }
}
