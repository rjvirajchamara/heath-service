<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\OnlineDoctorAppoinment;

class OnlineDoctorAppoinmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewOnlineDoctorAppoinment(Request $request){

        $doctor_id = $request->doctor_id;
        $date= Carbon::today()->toDateString();
        $time = Carbon::today()->now()->format("H:i");
        
        $OnlineDoctorAppoinment = OnlineDoctorAppoinment::where('doctors_id',$doctor_id)
         ->where('date',$date)->where('time','>=',$time)->get(['link','user_id']);

         $emptyArray = array();

         if ( $OnlineDoctorAppoinment ) {
             return response()->json(["OnlineDoctorAppoinment "=> $OnlineDoctorAppoinment ]);
         } else if (!$OnlineDoctorAppoinment ) {
             return response()->json($emptyArray,);
         }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function OnlineDoctorAppoinment(Request $request){


        $this->validate($request, [
            'doctors_id' => 'required',
            'description'=>'required',
            'link'=>'required'

            ]);

            $userData = $request->get('userData');
            $user_id = $userData['user_id'];

        try {

        $date= Carbon::today()->toDateString();
        $time = Carbon::today()->now()->format("H:i");
        $time2 = "00:03";
        $secs = strtotime($time2)-strtotime("00:00");
        $new_time = date("H:i",strtotime($time)+$secs);

        $onlineDoctorAppoinment = new OnlineDoctorAppoinment();

        $onlineDoctorAppoinment->user_id = $user_id ;
        $onlineDoctorAppoinment->doctors_id = $request->doctors_id;
        $onlineDoctorAppoinment->date=$date;
        $onlineDoctorAppoinment->time=$new_time;
        $onlineDoctorAppoinment->description = $request->description;
        $onlineDoctorAppoinment->active =1;
        $onlineDoctorAppoinment->link = $request->link;
        $onlineDoctorAppoinment->save();

        return response()->json(['status' => 1,'data' => "Successfully Saved"], 201);
        } catch (\Throwable $th) {
        return response()->json(['status' => 0,'data' => $th], 403);
        }

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OnlineDoctorAppoinment  $onlineDoctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function show(OnlineDoctorAppoinment $onlineDoctorAppoinment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OnlineDoctorAppoinment  $onlineDoctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineDoctorAppoinment $onlineDoctorAppoinment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OnlineDoctorAppoinment  $onlineDoctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function OnlineDoctorAppoinmenStatus(Request $request,$id){

        try {

            $RescheduleAppoinment = OnlineDoctorAppoinment::findorfail($id);
            $RescheduleAppoinment->active=$request->active;
            $RescheduleAppoinment->update();

            return response()->json(['status' => 1,'data' => "Successfully  Update"], 200);

            }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

    }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OnlineDoctorAppoinment  $onlineDoctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineDoctorAppoinment $onlineDoctorAppoinment)
    {
        //
    }
}
