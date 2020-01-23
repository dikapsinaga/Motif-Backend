<?php

namespace App;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pelapak extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='pelapaks';

    protected $fillable = [
        'name', 'email', 'password','alamat', 'foto_lapak', 'nama_pic', 'nomor_hp', 'foto_ktp'
    ];

    protected $hidden = [
        'password', 'remember_token',
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
