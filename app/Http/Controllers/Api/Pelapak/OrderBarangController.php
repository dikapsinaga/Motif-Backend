<?php

namespace App\Http\Controllers\Api\Pelapak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PembelianInvestasi as PembelianInvestasiResource;


use App\PembelianBarang;
use App\Produk;
use App\Plan;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\PembelianBarang as PembelianBarangResource;


class OrderBarangController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pelapaks' );
        $this->middleware('jwt.verify');
    }

    public function show(Request $request, $id)
    {
        $pembelian = PembelianBarang::find($id);
        return new PembelianBarangResource($pembelian);

        // return response()->json(compact('produk'),200);
    }

    public function index()
    {
        $pembelian = PembelianBarang::whereHas('produk', function($query){
            $query->whereHas('pelapak', function($query){
                $query->where('id', auth()->user()->id);
            });
        })->with('produk')->get();

        return PembelianBarangResource::collection($pembelian);
    }

    public function updateResi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_resi'=> 'required|string',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $data = $validator->validate();

        $pembelian = PembelianBarang::find($id);
        $pembelian->fill($data);
        $pembelian->status = 3;
        $pembelian->save();

        return response()->json(['message' => 'Sucsess Update Resi'], 200);
        

    }
}