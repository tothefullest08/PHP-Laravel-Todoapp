<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable
        = [
            'email',
            'password',
        ];

    /**
     * @var array
     */
    protected $hidden
        = [
            'remember_token',
        ];

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
