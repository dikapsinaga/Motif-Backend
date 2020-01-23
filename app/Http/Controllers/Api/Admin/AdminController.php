<?php

namespace App\Http\Controllers\Api\Admin;

use App\Admin;
use App\Berita;
use App\PembelianBarang;
use App\PembelianInvestasi;

use App\Produk;
use App\Plan;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\PembelianBarang as PembelianBarangResource;
use App\Http\Resources\PembelianInvestasi as PembelianInvestasiResource;
use App\Http\Resources\Plan as PlanResource;



use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'admins' );
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }


    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


        $token = compact('token');
        $request->session()->put('token', $token);

        return redirect('/admin/home');


    }

    public function showHome()
    {
        $token = session()->get('token');
        // dd($token);

         return view('admin.home')->with('token', $token);
        // return \View::make('admin.home')->with('token', $token);

    }

    public function showBerita()
    {
        $token = session()->get('token');

        $berita = Berita::orderBy('created_at', 'desc')->get();


        // $disk = \Storage::disk('gcs');
        // $berita->foto = $disk->get($berita->foto);

        return view('admin.berita')->with('berita', $berita);
        // return view('bidan.showPasien', ['pasien'=> $pasien]);

        // return \View::make('admin.home')->with('token', $token);

    }

    public function addBeritaForm()
    {
        return response()->json([
            'error' => false,
        ], 200);

    }

    public function addBerita(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'berita' => 'required|string'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validate();

        $disk = \Storage::disk('gcs');
        $file = $request->file('foto');
        $name = $file->getClientOriginalName();

        $url_foto = $disk->put('berita'.'/'.$name, $file);
        
        $berita= new Berita();
        $berita->fill($data);
        $berita->foto = $url_foto;

        $berita->save();

        return response()->json([
            'error' => false,
            'berita' => $data
        ], 200);

    }

    public function showDetails($id)
    {
        $berita = Berita::find($id);

        return response()->json([
            'error' => false,
            'berita' => $berita
        ], 200);
    }

    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'berita' => 'required|string'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validate();


        $berita = Berita::find($id);

        
        $berita->fill($data);
        
        if($request->hasFile('foto')){
            $disk = \Storage::disk('gcs');
            $file = $request->file('foto');
            $name = $file->getClientOriginalName();
    
            $url_foto = $disk->put('berita'.'/'.$name, $file);

            $berita->foto = $url_foto;
        }
        
        $berita->save();

        return response()->json([
            'error' => false,
            'berita' => $berita
        ], 200);

    }

    public function delete(Request $request, $id)
    {
        $berita = Berita::destroy($id);
        return response()->json(['message' => 'Product Has Been Delete'], 200);

    }

    public function showPembayaranProdukNotPaid()
    {
        return view('admin.produkNotPaid');
    }

    public function getListProduk($id)
    {
        $pembelian = PembelianBarang::with(['produk','pembeli'])->where('status', $id)->get();
        return PembelianBarangResource::collection($pembelian);        
    }

    public function showPembayaranProdukNotConfirmed()
    {
        return view('admin.produkNotConfirmed');
    }

    public function konfirmasiPembayaranProduk($id)
    {
        $pembelian = PembelianBarang::find($id);
        $pembelian->status =  2;
        $pembelian->save();
        
        return response()->json([
            'error' => false,
            'pembelian' => $pembelian
        ], 200);
    }

    public function showPesananProdukDiproses()
    {
        return view('admin.produkDiproses');
    }

    public function showPesananProdukDikirim()
    {
        return view('admin.produkDikirim');
    }


    public function showPembayaranInvestasiNotPaid()
    {
        return view('admin.investasiNotPaid');
    }


    public function getListInvestasi($id)
    {
        $pembelian = PembelianInvestasi::with(['plan','pembeli'])->where('status', $id)->get();
        return PembelianInvestasiResource::collection($pembelian);        
    }

    public function showPembayaranInvestasiNotConfirmed()
    {
        return view('admin.investasiNotConfirmed');
    }

    public function konfirmasiPembayaranInvestasi($id)
    {
        $pembelian = PembelianInvestasi::find($id);
        $pembelian->status =  2;
        $pembelian->save();

        $plan = Plan::find($pembelian->plan_id);
        
        $plan->dana_terkumpul += $pembelian->nominal;
        
        if($plan->dana_terkumpul >= $plan->dana_dibutuhkan){
            $plan->status = 1;  
        }
        $plan->save();
        
        return response()->json([
            'error' => false,
            'pembelian' => $pembelian
        ], 200);
    }

    public function showPembayaranInvestasiDiproses()
    {
        return view('admin.investasiDiproses');
    }



    public function showPembayaranHasilInvestasiNotPaid()
    {
        return view('admin.hasilInvestasiNotPaid');

    }

    public function getStatusInvestasi($id)
    {
        $plan = Plan::with('pelapak')->where('status', $id)->get();
        
        return PlanResource::collection($plan);        
    }

    public function konfirmasiPembayaranHasilInvestasi($id)
    {
        $plan = Plan::find($id);
        $plan->status =  3;
        $plan->save();
        
        return response()->json([
            'error' => false,
            'plan' => $plan
        ], 200);
    }

    public function showPembayaranHasilInvestasiNotConfirmed()
    {
        return view('admin.hasilInvestasiNotConfirmed');

    }

    public function showPembayaranHasilInvestasiDiproses()
    {
        return view('admin.hasilInvestasiDiproses');

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}