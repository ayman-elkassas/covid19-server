<?php

namespace App\Http\Controllers\User\Report;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\TreatmentReport;
use App\Models\User;
use Illuminate\Http\Request;

class TreatmentReportController extends Controller
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
        //
        try {

            $title=$request->title;
            $desc=$request->desc;

            if($request->get("role")===1){
                $user=User::find($request->get("user_id"));
                $user->reports()->attach($request->get("doctor_id"),['title'=>$title,'desc'=>$desc]);
            }
            else{
                $user=Doctor::find($request->get("doctor_id"));
                $user->reports()->attach($request->get("user_id"),['title'=>$title,'desc'=>$desc]);
            }

            return response()->json($user, 200);
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
        try {

            $obj=json_decode($id);

            if($obj->role===1){
                $user=User::find($obj->id);
            }
            else{
                $user=Doctor::find($obj->id);
            }

//            $user=User::find($id);

            $reports=$user->reports;

            return response()->json($reports, 200);
        }catch (\Exception $ex){
            return response()->json($ex, 404);
        }
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
    }
}
