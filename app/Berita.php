<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Berita extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='beritas';

    protected $fillable = [
        'judul', 'berita', 'foto'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
