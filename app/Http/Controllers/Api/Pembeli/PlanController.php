<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Pelapak;
use App\Plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Plan as PlanResource;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PlanController extends Controller
{
    public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'pembelis' );
        $this->middleware('jwt.verify');

    }

    public function index()
    {
        $plan = Plan::all();
        return PlanResource::collection($plan);
    }

    public function show(Request $request, $id)
    {
        $plan = Plan::find($id);
        return new PlanResource($plan);
    }
    
}