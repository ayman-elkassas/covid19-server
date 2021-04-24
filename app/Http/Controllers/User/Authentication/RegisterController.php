<?php

namespace App\Http\Controllers\User\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    //
    public final function DoRegister(Request $request):object
    {
        //
        try {

            //todo:Avatar
             if($request->avatar!==""){
                 //todo:Avatar
                 $strpos=strpos($request->avatar,';');
                 $sub=substr($request->avatar,0,$strpos);
                 $ex=explode('/',$sub)[1];
                 $name=time().'.'.$ex;
                 $img=Image::make($request->avatar)->resize(350,350);
                 $upload_path="/Users/avatar/";
                 //todo:after make link (php artisan storage:link) save as following
                 move_uploaded_file($img->encode(),public_path().'upload'."/media/".$upload_path.$name);
//                 Storage::disk("public_upload")->put("/media/".$upload_path.$name, (string) $img->encode());
             }

            //todo:create new object

            $user=new User();
            $user->fname=ucwords(strtolower($request->fname));
            $user->lname=ucwords(strtolower($request->lname));
            $user->email=$request->email;
            $user->phone=$request->phone;
            $user->skills="";
            $user->fields_follow="";
            $user->password=bcrypt($request->get('password'));
            $user->avatar="/Users/avatar/".$name;
            $user->save();

            $token=JWTAuth::attempt($request->only('email','password'));

            return response()->json(['success'=>true,
                'data'=>$user,'access_token'=>$token,'token_type'=>'bearer',
                'expire_in'=>config('jwt.ttl')], 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }
}
