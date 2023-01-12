<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TrainerDoctorAppointment;
use Illuminate\Http\Request;

class TrainerDoctorAppointmentController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainerDoctorAppointment  $trainerDoctorAppointment
     * @return \Illuminate\Http\Response
     */
    public function show(TrainerDoctorAppointment $trainerDoctorAppointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainerDoctorAppointment  $trainerDoctorAppointment
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainerDoctorAppointment $trainerDoctorAppointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainerDoctorAppointment  $trainerDoctorAppointment
     * @return \Illuminate\Http\Response
     */
    public function SearchClients(Request $request){
       $client_name = $request->client_name;


        $Client_Information = Client::where('full_name',$client_name )->where('full_name', 'LIKE','%' .$client_name . '%')
        ->get(['full_name','id','mobile_no','dob']);


        $emptyArray = array();

      if ( $Client_Information ) {
      return response()->json(["Client Information"=> $Client_Information ]);
      } else if (!  $Client_Information ) {
      return response()->json($emptyArray,);

      }
     }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainerDoctorAppointment  $trainerDoctorAppointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainerDoctorAppointment $trainerDoctorAppointment)
    {
        //
    }
}
