<?php

namespace App\Http\Controllers\Api\Pembeli;

use App\Progress;
use App\Pembeli;
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
        config()->set( 'auth.defaults.guard', 'pembelis' );
        $this->middleware('jwt.verify');
    }

    public function index($id)
    {
        $progress = Progress::where('plan_id', $id)
                                    ->orderBy('date', 'desc')
                                    ->get();
        return ProgressResource::collection($progress);
    }
}