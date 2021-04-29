<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CurrentDoctorController extends Controller
{
    //
    public function index(Request $request){
        return response()->json([
            'success'=>true,
            'user'=>$request->user('web1')
        ]);
    }

    public function logout(){
        try {
            JWTAuth::invalidate();
            return response()->json([
                'message' => "Logged Of Successfully"
            ], 200);

        }catch (\Exception $ex){
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
