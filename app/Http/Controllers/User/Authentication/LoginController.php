<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class LoginController extends Controller
{
    //
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;

        //todo:should change provider and then implement JWTSubject
//        Config::set('jwt.user', Doctor::class);
//        Config::set('auth.providers', ['doctors' => [
//            'driver' => 'eloquent',
//            'model' => Doctor::class,
//        ]]);
    }

    public final function DoLogin(Request $request)
    {

        $credential = $request->only('email', 'password');

        if($request->role==="2"){
            $token=auth('web1')->attempt($credential);
            $user = auth('web1')->user();
        }
        else{
            $token=JWTAuth::attempt($credential);
            $user = JWTAuth::user();
        }

        if(!$token){
            return ['error'=>'invalid_credentials'];
        } else {
            try {
                return response()->json(['success'=>true,
                    'data'=>$user,'access_token'=>$token,'token_type'=>'bearer',
                    'expire_in'=>config('jwt.ttl')], 200);

            }catch (\Exception $ex){
                return response()->json($ex, 404);
            }

        }
    }
}
