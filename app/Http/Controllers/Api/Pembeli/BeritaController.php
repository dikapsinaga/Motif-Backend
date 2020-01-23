<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Berita;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\Http\Resources\Berita as BeritaResource;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BeritaController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
    }

    public function index()
    {
        $berita = Berita::all();
        return BeritaResource::collection($berita);
    }

    public function show($id)
    {
        $berita = Berita::find($id);
        return new BeritaResource($berita);
    }
}
