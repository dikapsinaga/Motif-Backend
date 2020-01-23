<?php

namespace App\Http\Controllers\Api\Pelapak;

use App\Progress;
use App\Pelapak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Progress as ProgressResource;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ProgressController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pelapaks' );
        $this->middleware('jwt.verify');
    }

    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:255'
        ]);
            
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $data = $validator->validate();
 
        $progress = new Progress();
        $progress->fill($data);
        $progress->plan_id = $id;
        $progress->date = now();
        
        $progress->save();
        return response()->json(['message' => 'Success']);
    }

    public function index($id)
    {
        $progress = Progress::where('plan_id', $id)
                                    ->orderBy('date', 'desc')
                                    ->get();
        return ProgressResource::collection($progress);
    }
    
}