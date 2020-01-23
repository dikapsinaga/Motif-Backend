<?php

namespace App\Http\Controllers\Api\Pelapak;

use App\Pelapak;
use App\Plan;
use App\PembelianInvestasi;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Plan as PlanResource;
use App\Http\Resources\PembelianInvestasi as PembelianInvestasiResource;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PlanController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pelapaks' );
        $this->middleware('jwt.verify');

    }

    public function index()
    {
        $plan = Plan::where('pelapak_id', auth()->user()->id)->get();
        return PlanResource::collection($plan);
    }

    public function show(Request $request, $id)
    {
        $plan = Plan::find($id);
        return new PlanResource($plan);

    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profit'=> 'required|numeric',
            'dana_dibutuhkan'=> 'required|numeric',
            'days'=> 'required|numeric',
            'return_days'=> 'required|numeric',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
            
        $data = $validator->validate();
        
        
        $disk = \Storage::disk('gcs');        
        $url_plan = $disk->put('plan'.'/'.auth()->user()->id, $request->file('foto'));
        
        
        $plan = new Plan();
        $plan->fill($data);
        $plan->dana_terkumpul = 0;
        $plan->pelapak_id = auth()->user()->id;
        $plan->foto = $url_plan;
        $plan->start_date = now();
        $plan->save();

        return response()->json(['message' => 'Sucsess Added Plan'], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'profit'=> 'required|numeric',
            'dana_dibutuhkan'=> 'required|numeric',
            'days'=> 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = $validator->validate();

        $plan = Plan::find($id);
        
        $plan->fill($data);
        if($request->hasFile('foto')){
            $disk = \Storage::disk('gcs');        
            $url_foto = $disk->put('plan'.'/'.auth()->user()->id, $request->file('foto'));
            $produk->foto = $url_foto;
        }

        $plan->save();

        return new PlanResource($plan);

    }

    public function delete(Request $request, $id)
    {
        $plan = Plan::find($id);
        
        if($plan->dana_terkumpul > 0){
            return response()->json(['message' => 'Cannot Delete Plan'], 200);

        }        
        $plan->delete();
        return response()->json(['message' => 'Plan Has Been Delete'], 200);
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
        $url_plan = $disk->put('plan'.'/'.auth()->user()->id, $request->file('foto'));
        
        $plan = Plan::find($id);
        $plan->foto = $url_plan;
        $plan->save();
        
        // return response()->json(['message' => 'Photo Has Been Changed.'], 200);
        return new PlanResource($plan);
    }

    public function bayarPlan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rekening' => 'required|string',
            'nama_rekening' => 'required|string|max:255',
            'foto_resi' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $data = $validator->validate();

        $plan = Plan::find($id);
        
        $plan->fill($data);
        
        $disk = \Storage::disk('gcs');        
        $url_foto = $disk->put('pembayaran/plan'.'/'.auth()->user()->id, $request->file('foto_resi'));
        
        $plan->foto_resi = $url_foto;
        $plan->status = 2;

        $plan->save();

        return response()->json(['message' => 'Success'], 200);


        // return new PlanResource($plan);
    }


    public function showInvestor($id)
    {
        $investor = PembelianInvestasi::with('pembeli')->where('plan_id', $id)->get();

        return PembelianInvestasiResource::collection($investor);

    }
    
}
