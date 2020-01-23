<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Plan extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table ='plans';
    public $timestamps = false;


    protected $fillable = [
        'pelapak_id', 'judul', 'deskripsi','foto', 'profit', 'dana_dibutuhkan',
        'dana_terkumpul', 'days', 'return_days', 'start_date', 'nomor_rekening', 
        'nama_rekening', 'foto_resi'
    ];

    protected $hidden = [
        'remember_token',
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
