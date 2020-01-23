<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class PembelianInvestasi extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='pembelian_investasi';

    protected $fillable = [
        'plan_id', 'pembeli_id', 'nominal', 'nomor_rekening', 'nama_rekening', 'status',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    public function pembeli()
    {
        return $this->belongsTo('App\Pembeli');
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
