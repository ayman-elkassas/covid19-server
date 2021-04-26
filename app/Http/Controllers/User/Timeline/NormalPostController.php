<?php

namespace App\Http\Controllers\User\Timeline;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NormalPostController extends Controller
{
    //
    public final function getAllPostByUserId($id):object{
        try {
            $user=User::find($id);
            $posts=$user->posts;

            return response()->json($posts, 200);
        }catch (\Exception $ex){
            return response()->json("Error", 404);
        }
    }
}
