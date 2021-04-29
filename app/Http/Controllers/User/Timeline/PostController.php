<?php

namespace App\Http\Controllers\User\Timeline;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $post=new Post();
            $post->title=$request->get("postTitle");
            $post->desc=$request->get("postDesc");
            $post->type=$request->get("postType");

            if($request->get("role")===1){
                $post->user_id=$request->get("Uid");
            }
            else{
                $post->doctor_id=$request->get("Uid");
            }

            $post->save();

            try {
                $mimeType=explode("/",mime_content_type($request->get("postCover")))[0];

                $arr=saveInStorage($request->get("postCover"),$mimeType,"/Users/post/cover/",$post->id);
                $post->post_cover=$arr[1].$arr[0];
            }catch (\Exception $ex){
                return response()->json($post, 200);
            }

            $post->save();

            return response()->json($post, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            Post::findOrFail($id)->delete();

            return response()->json("Deleted Successfully", 200);
        }catch (\Exception $ex){
            return response()->json("Error", 404);
        }
    }
}
