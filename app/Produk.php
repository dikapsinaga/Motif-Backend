<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Produk extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='produks';

    protected $fillable = [
        'pelapak_id', 'judul', 'nama','jenis', 'harga', 'stok', 'deskripsi', 'foto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pelapak()
    {
        return $this->belongsTo('App\Pelapak');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
