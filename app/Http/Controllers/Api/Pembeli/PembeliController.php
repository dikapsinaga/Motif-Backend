<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Pembeli;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PembeliController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string|max:255',
            'foto_ktp'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $data = $validator->validate();
        
        $pembeli = Pembeli::find(auth()->user()->id);
        
        $disk = \Storage::disk('gcs');
        
        $url_ktp = $disk->put('pembeli/ktp'.'/'.auth()->user()->id, $request->file('foto_ktp'));
        
        $pembeli->fill($data);
        $pembeli->foto_ktp = $url_ktp;
        $pembeli->save();

        return response()->json(['message' => 'Profile haas been updated'], 200);

    }
    
}
