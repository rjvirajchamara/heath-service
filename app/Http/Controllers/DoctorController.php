<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Doctor;
use App\Models\DoctorAvailableDate;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AllDoctor(){

        $all_doctor = Doctor::get();

        $emptyArray = array();

        if ($all_doctor) {
        return response()->json(["AllDoctor"=>$all_doctor]);
        } else if (!$all_doctor) {
        return response()->json($emptyArray,);
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
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function DoctorAppointmentAmount(Request $request,$id){


            $this->validate($request, [
            'amount' =>'required|numeric',
            'currency'=>'required'
            ]);

            try {
            $DoctorOnline = Doctor::findorfail($id);
            $DoctorOnline->amount=$request->amount;
            $DoctorOnline->currency=$request->currency;
            $DoctorOnline->save();

            return response()->json(['status' => 1,'data' => "Successfully Updated"], 200);

            }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

    }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */

    public function DoctorOnline(Request $request,$id){
        try {
        $this->validate($request, [
        'active' =>'required'
        ]);


        $DoctorOnline = Doctor::findorfail($id);
        $DoctorOnline->active=$request->active;
        $DoctorOnline->save();

        return response()->json(['status' => 1,'data' => "Successfully Updated"], 200);

        }catch (Exception $e) {
        return response()->json(['status' => 0,'data' => $e ], 403);

    }


    }

    public function ViweOnlineDoctor(){

        $viweOnlineDoctor=Doctor::where('active',1)->get(['name','id']);

          $emptyArray = array();

          if ($viweOnlineDoctor) {
          return response()->json(["viweOnlineDoctor"=>$viweOnlineDoctor]);
          } else if (!$viweOnlineDoctor) {
          return response()->json($emptyArray,);
          }
          }

         public function SearchOnlineDoctor(Request $request){

            $doctorname =  $request->name;
            $doctor_details =doctor::where('active',1)->where('name', 'LIKE', $doctorname. '%')->get(['name','id']);
            $emptyArray = array();

          if ( $doctor_details) {
          return response()->json(["doctordetails"=>$doctor_details]);
          } else if (! $doctor_details) {
          return response()->json($emptyArray,);

          }
         }
        }
