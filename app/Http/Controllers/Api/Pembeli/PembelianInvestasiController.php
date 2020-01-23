<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PembelianInvestasi as PembelianInvestasiResource;


use App\PembelianInvestasi;
use App\Plan;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PembelianInvestasiController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
        $this->middleware('jwt.verify');
    }

    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nominal'=> 'required|numeric',
            'nomor_rekening' => 'required|string',
            'nama_rekening' => 'required|string|max:255',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $data = $validator->validate();
        
        $pembelian = new PembelianInvestasi();
        $pembelian->fill($data);
        $pembelian->plan_id = $id;
        $pembelian->pembeli_id = auth()->user()->id;

        
        $plan = Plan::find($id);
        $plan->dana_terkumpul += $pembelian->nominal;
        
        if($plan->dana_terkumpul > $plan->dana_dibutuhkan){
            return response()->json(['message' => 'Nominal yang anda masukan melebihi kebutuhan'], 404);            
        }
        $pembelian->save();
        return response()->json(['message' => 'Sucsess Buy Investasi'], 200);
    }

    public function index()
    {
        $pembelianInvestasi = PembelianInvestasi::with('plan')
                                                ->where('pembeli_id', auth()->user()->id)
                                                ->get();
        return PembelianInvestasiResource::collection($pembelianInvestasi);
    }

    public function show(Request $request, $id)
    {
        $pembelianInvestasi = PembelianInvestasi::find($id);
        return new PembelianInvestasiResource($pembelianInvestasi);

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
        $url_foto = $disk->put('pembelian/investasi/buktiPembayaran'.'/'.auth()->user()->id, $request->file('foto_pembayaran'));
        
        $pembelian = PembelianInvestasi::find($id);
        $pembelian->foto_pembayaran = $url_foto;
        $pembelian->status = 1;
        $pembelian->save();
    
        return response()->json(['message' => 'Sucsess Upload Foto'], 200);

    }



}