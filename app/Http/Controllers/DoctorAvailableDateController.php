<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorAppoinment;
use App\Models\DoctorAvailableDate;

class DoctorAvailableDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewDoctorAvailableDate(Request $request){


        $userData = $request->get('userData');
        $doctor_id = $userData['user_id'];

        $DoctorAvailableDate=DoctorAvailableDate::where('doctor_id', $doctor_id)
        ->orderBy('id', 'DESC')
        ->get(['date','start_time','end_time']);

        $emptyArray = array();

        if ($DoctorAvailableDate) {
            return response()->json(["DoctorAvailableDate"=>$DoctorAvailableDate]);
        } else if (!$DoctorAvailableDate) {
            return response()->json($emptyArray,);
        }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateDoctorAvailableDate(Request $request){

        $userData = $request->get('userData');
        $doctor_id = $userData['user_id'];

        $this->validate($request, [
            'date' =>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            ]);

            try {
            $DoctorAvailableDate = new DoctorAvailableDate();
            $DoctorAvailableDate->doctor_id=$doctor_id;
            $DoctorAvailableDate->date=$request->date;
            $DoctorAvailableDate->start_time=$request->start_time;
            $DoctorAvailableDate->end_time=$request->end_time;
            $DoctorAvailableDate->save();

            return response()->json(['status' => 1,'data' => "Successfully Saved"], 201);
            }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

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
     * @param  \App\Models\DoctorAvailableDate  $doctorAvailableDate
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorAvailableDate $doctorAvailableDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorAvailableDate  $doctorAvailableDate
     * @return \Illuminate\Http\Response
     */
    public function UpdateDoctorAvailableDate(Request $request){


        $userData = $request->get('userData');
        $doctor_id= $userData['user_id'];

        $this->validate($request, [
            'date' =>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            ]);

           //try {

            $ids = DoctorAvailableDate::where('doctor_id',$doctor_id)->first('id');
            $id_s=$ids->id;

            $DoctorAvailableDate = DoctorAvailableDate::findorfail($id_s);
            $DoctorAvailableDate->date=$request->date;
            $DoctorAvailableDate->start_time=$request->start_time;
            $DoctorAvailableDate->end_time=$request->end_time;
            $DoctorAvailableDate->save();

            return response()->json(['status' => 1,'data' => "Successfully Updated"], 200);
          //  }catch (Exception $e) {
           // return response()->json(['status' => 0,'data' => $e ], 403);


           // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorAvailableDate  $doctorAvailableDate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorAvailableDate $doctorAvailableDate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorAvailableDate  $doctorAvailableDate
     * @return \Illuminate\Http\Response
     */
    public function DeleteDoctorAvailableDate(Request $request,$id){

        $doctor_id=$request->doctor_id;
        try {

        $get_doctor_available = DoctorAvailableDate::where('id',$id)
        ->get(['date','start_time','end_time']);
      //  dd($get_doctor_available);


        foreach ($get_doctor_available  as $get_doctor_availables) {

            $dates=$get_doctor_availables->date;
            $time = Carbon::today()->now()->format("H:i");


           $get_all_doctor_appointment = DoctorAppoinment::where('date',$dates)
            ->where('time','>=',$time)
            ->where('doctors_id',$doctor_id)
            ->get(['date','time']);

          }

            if(!$get_all_doctor_appointment->isEmpty()){

             $DoctorAvailableDate = DoctorAvailableDate::findorfail($id);
             $DoctorAvailableDate->delete();


           return response()->json(['status' => 1,'data' => "Successfully Deleted"], 200);


            }else{
                return response()->json(['status' => 0,'data' => "Please Reschudul this day Appointment"], 403);
            }

         } catch (Exception $e) {return response()->json(['status' => 0,'data' => $e], 403);
            }
       }
    }
