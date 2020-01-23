<?php

namespace App\Http\Controllers\Api\Pelapak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Pelapak;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PelapakController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pelapaks' );
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string|max:255',
            'foto_lapak'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_pic' => 'required|string',
            'nomor_hp'=> 'required|numeric|digits_between:9,13',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $data = $validator->validate();
        
        $pelapak = Pelapak::find(auth()->user()->id);
        
        $disk = \Storage::disk('gcs');
        
        $url_lapak = $disk->put('lapak'.'/'.auth()->user()->id, $request->file('foto_lapak'));
        $url_ktp = $disk->put('ktp'.'/'.auth()->user()->id, $request->file('foto_ktp'));
        
        // dd($disk->get($url_ktp));

        $pelapak->fill($data);
        $pelapak->foto_lapak = $url_lapak;
        $pelapak->foto_ktp = $url_ktp;
        $pelapak->save();

        return response()->json([
            'error' => false,
        ], 200);
    }
    
}
