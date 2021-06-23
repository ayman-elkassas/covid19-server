<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\PublicInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;

class NormalUserController extends Controller
{
    //
    public final function getUserByCharFromFName($searchChar):object{
        try {
            $obj=json_decode($searchChar);

            if($obj->role==='2'){

                $users=DB::table("users")->where("fname",
                    "like",$obj->char.'%')
                    ->limit(10)
                    ->get();
                return response()->json($users, 200);
            }else {
                $users=DB::table("doctors")->where("fname",
                    "like",$obj->char.'%')
                    ->limit(10)
                    ->get();
                return response()->json($users, 200);
            }
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }

    public final function setDoctorFollow($ids=null):object{
        try {
            $obj=json_decode($ids);

            if($obj->role===1 &&!$obj->selfRelation){
                $user=User::findOrFail($obj->user_id);
                $user->patients()->syncWithoutDetaching($obj->doctor_id);
            }else if($obj->role===2) {
                $user = Doctor::findOrFail($obj->doctor_id);
                $user->patients()->syncWithoutDetaching($obj->user_id);
            }
            else if($obj->role===1 &&$obj->selfRelation){
                $user=User::findOrFail($obj->user_self);
                $user->user_id=$obj->user_id;
                $user->save();
            }

            return response()->json($obj, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }

    public final function getAllInfo():object{
        try {
            $info=PublicInfo::all();

            return response()->json($info, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }

    public final function setInfo(Request $request):object{
        try {
            $info=new PublicInfo();

            $info->title=$request->title;
            $info->desc=$request->desc;

            $info->save();

            return response()->json($info, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }

    public final function getOwnPost($ids):object{
        try {

            $obj=json_decode($ids);

            if($obj->role===1){
                $user=User::find($obj->user_id);
            }
            else{
                $user=Doctor::find($obj->user_id);
            }

//            $user=User::find($ids);

            $posts=$user->posts;

            return response()->json($posts, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }
}
