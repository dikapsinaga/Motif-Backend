<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PembelianBarang as PembelianBarangResource;


use App\PembelianBarang;
use App\Produk;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PembelianBarangController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
        $this->middleware('jwt.verify');

    }

    public function index()
    {
        $pembelian = PembelianBarang::with('produk')
                                    ->where('pembeli_id', auth()->user()->id)
                                    ->get();

        return PembelianBarangResource::collection($pembelian);
    }

    public function show(Request $request, $id)
    {
        $pembelian = PembelianBarang::find($id);
        return new PembelianBarangResource($pembelian);

        // return response()->json(compact('produk'),200);
    }
    
    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah'=> 'required|numeric',
            'alamat_pengiriman' => 'required|string|max:255',
            'nomor_rekening' => 'required|string',
            'nama_rekening' => 'required|string|max:255',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $data = $validator->validate();
        
        $pembelian = new PembelianBarang();
        $pembelian->fill($data);
        $pembelian->produk_id = $id;
        $pembelian->pembeli_id = auth()->user()->id;

        $produk = Produk::find($id);
        
        // cek stok
        if(!$produk->stok > 0 ){
            return response()->json(['message' => 'Failed To Buy Product'], 200);
        }
        
        // beli barang
        $pembelian->total = $produk->harga * $pembelian->jumlah;
        $pembelian->save();
        
        // update stok
        $produk->stok -= $pembelian->jumlah;
        $produk->save();
        
        return response()->json(['message' => 'Sucsess Buy Product'], 200);
    }

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'foto_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = $validator->validate();

        $disk = \Storage::disk('gcs');        
        $url_foto = $disk->put('pembelian/barang/buktiPembayaran'.'/'.auth()->user()->id, $request->file('foto_pembayaran'));
        
        $pembelian = PembelianBarang::find($id);
        $pembelian->foto_pembayaran = $url_foto;
        $pembelian->status = 1;
        $pembelian->save();
    
        return response()->json(['message' => 'Sucsess Upload Foto'], 200);

    }

    
}
