<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Progress extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='progress';
    public $timestamps = false;


    protected $fillable = [
        'plan_id', 'judul', 'deskripsi','date'
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
