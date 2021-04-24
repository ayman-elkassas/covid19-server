<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
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
        Config::set('jwt.user', User::class);
        Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => User::class,
        ]]);
    }

    public final function DoLogin(Request $request)
    {

        $credential = $request->only('email', 'password');

        if(!$token=JWTAuth::attempt($credential)){
            return ['error'=>'invalid_credentials'];
        } else {
            $user = JWTAuth::user();
            $provider = "users";

            return response()->json(['success'=>true,
                'data'=>$user,'access_token'=>$token,'token_type'=>'bearer',
                'expire_in'=>config('jwt.ttl')], 200);
        }
    }
}
