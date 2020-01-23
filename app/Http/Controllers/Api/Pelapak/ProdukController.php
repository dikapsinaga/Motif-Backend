<?php

namespace App\Http\Controllers\Api\Pelapak;

use App\Produk;
use App\Pelapak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Produk as ProdukResource;
use Illuminate\Support\Str;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProdukController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pelapaks' );
        $this->middleware('jwt.verify');

    }

    public function index()
    {
        $produk = Produk::where('pelapak_id', auth()->user()->id)->get();
        return ProdukResource::collection($produk);
    }
    
    
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'nama'=>'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga'=> 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $data = $validator->validate();
                
        $disk = \Storage::disk('gcs');        
        $url_foto = $disk->put('produk'.'/'.auth()->user()->id, $request->file('foto'));
 
        $produk = new Produk();
        $produk->fill($data);
        $produk->pelapak_id = auth()->user()->id;
        $produk->foto = $url_foto;
        
        $produk->save();
        return response()->json(['message' => 'Success']);
        
    }
    
    public function show(Request $request, $id)
    {
        // $produk = Produk::find($id);
        $produk = Produk::with('pelapak')->find($id);
        return new ProdukResource($produk);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'nama'=>'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga'=> 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = $validator->validate();

        $produk = Produk::find($id);
        if(!$produk){
            return response()->json(['message' => 'Product Not Found']);
        }
        
        $produk->fill($data);
        
        if($request->hasFile('foto')){
            $disk = \Storage::disk('gcs');        
            $url_foto = $disk->put('produk'.'/'.auth()->user()->id, $request->file('foto'));
            $produk->foto = $url_foto;
        }
        
        $produk->save();

        return new ProdukResource($produk);
        // return response()->json(compact('token'));
    }

    public function delete(Request $request, $id)
    {
        $produk = Produk::destroy($id);
        return response()->json(['message' => 'Product Has Been Delete'], 200);

    }

    public function changeFoto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = $validator->validate();

        $disk = \Storage::disk('gcs');        
        $url_foto = $disk->put('produk'.'/'.auth()->user()->id, $request->file('foto'));
        
        $produk = Produk::find($id);
        $produk->foto = $url_foto;
        $produk->save();
        

        // return response()->json(['message' => 'Photo Has Been Changed.'], 200);
        return new ProdukResource($produk);


    }
}
