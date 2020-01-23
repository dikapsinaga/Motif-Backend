<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class PembelianBarang extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='pembelian_barang';
    // public $timestamps = false;

    protected $fillable = [
        'produk_id', 'pembeli_id', 'jumlah', 'total', 'foto_resi', 'alamat_pengiriman', 'nomor_rekening', 'nama_rekening', 'nomor_resi', 'status',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function produk()
    {
        return $this->belongsTo('App\Produk');
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
