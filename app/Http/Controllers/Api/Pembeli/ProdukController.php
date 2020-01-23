<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Produk;
use App\Pembeli;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Produk as ProdukResource;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProdukController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
        $this->middleware('jwt.verify');
    }

    public function index()
    {
        $produk = Produk::with('pelapak')->get();
        return ProdukResource::collection($produk);
    }
    
    public function show(Request $request, $id)
    {
        $produk = Produk::with('pelapak')->find($id);
        // $produk = Produk::with('pelapak')->where('id', $id)->get();
        return new ProdukResource($produk);
    }
}
