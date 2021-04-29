<?php

namespace App\Http\Controllers\User\Timeline;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\PrivateSituation;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class NormalPostController extends Controller
{
    //
    public final function getAllPostByUserId($id):object{
        try {
            $obj=json_decode($id);
//
            if($obj->role===1){
                $user=User::find($obj->user_id);
            }
            else{
                $user=Doctor::find($obj->user_id);
            }

//            $user=User::find($id);

            $posts=$user->posts;

            $patientsFollow=$user->patients;

            if($patientsFollow!==null){
                foreach ($patientsFollow as $followers){
                    foreach ($followers->posts as $follower){
                        $posts->push($follower);
                    }
                }

                foreach ($posts as $post){
                    if($post->user_id!==null){
                        $post["avatar"]=User::find($post->user_id)->avatar;
                    }
                    else{
                        $post["avatar"]=Doctor::find($post->doctor_id)->avatar;
                    }
                }
            }

            return response()->json($posts, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }
}
