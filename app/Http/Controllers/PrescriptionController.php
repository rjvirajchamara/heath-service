<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\trainer;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\DoctorAppoinment;
use App\Models\PrescriptionDetail;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViweUserPrescription (Request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
         $Prescription = Prescription::with(['getdoctor','getuser'])
        ->where('user_id',$user_id)
           ->get()
           ->map(
            function ($Prescription) {

                $birthDate = $Prescription->getuser->birth_date;
                $years = \Carbon\Carbon::parse( $birthDate)->age;

                $user_name=Client::where('user_id',$Prescription->user_id)->value('full_name');
                if($user_name==null){
                $user_name =trainer::where('user_id',$Prescription->user_id)->value('name');
                }

               return[
                'invoice' => $Prescription->id,
                'DoctorNote' => $Prescription->doctor_not,
                'date' => $Prescription->date,
                'time' => $Prescription->time,
                'doctor_name' => $Prescription->getdoctor->name,
                'user_name' =>$user_name,
                'dateofbirth'=>$years,
            ];
           }
         );

        $emptyArray = array();

        if ($Prescription) {
            return response()->json(["Prescription"=>$Prescription]);
        } else if (!$Prescription) {
            return response()->json($emptyArray,);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViweDoctorPrescription (Request $request){

      $doctor_appoinment_id=$request->doctor_appoinment_id;
       $Prescription = Prescription::with(['prescription_details','getuser'])
        ->where('doctor_appoinment_id',$doctor_appoinment_id)
           ->get()
           ->map(
            function ($Prescription) {
                $birthDate = $Prescription->getuser->birth_date;
                $years = \Carbon\Carbon::parse($birthDate)->age;
                 $user_name=Client::where('user_id',$Prescription->user_id)->value('full_name');
                 if($user_name==null){
                 $user_name =trainer::where('user_id',$Prescription->user_id)->value('name');
                }
                 return[
                'invoice' => $Prescription->id,
                'DoctorNote' => $Prescription->doctor_note,
                'date' => $Prescription->date,
                'time' => $Prescription->time,
                'doctor_name' => $Prescription->getdoctor->name,
                'user_name' =>$user_name,
                'dateofbirth'=>$years,
                'medicine'=>$Prescription->prescription_details,

            ];
           }
         );

        $emptyArray = array();

        if ($Prescription) {
            return response()->json(["Prescription"=>$Prescription]);
        } else if (!$Prescription) {
            return response()->json($emptyArray,);
        }


    }

    public function ViweSummaryDoctorPrescription (Request $request){

        $doctor_id=$request->doctor_id;
         $Prescription = Prescription::with(['prescription_details','getuser'])
          ->where('doctor_id',$doctor_id)
             ->get()
             ->map(
              function ($Prescription) {
                   $birthDate = $Prescription->getuser->birth_date;
                   $years = \Carbon\Carbon::parse($birthDate)->age;
                   $user_name=Client::where('user_id',$Prescription->user_id)->value('full_name');
                   if($user_name==null){
                   $user_name =trainer::where('user_id',$Prescription->user_id)->value('name');
                  }
                   return[
                  'date' => $Prescription->date,
                  'time' => $Prescription->time,
                  'doctor_name' => $Prescription->getdoctor->name,
                  'user_name' =>$user_name,
                  'dateofbirth'=>$years,
               ];
             }
           );

          $emptyArray = array();

          if ($Prescription) {
              return response()->json(["Prescription"=>$Prescription]);
          } else if (!$Prescription) {
              return response()->json($emptyArray,);
          }


      }

    public function viweCreatePrescription (Request $request){

         $doctor_id=$request->doctor_id;
         $check_prescription =DoctorAppoinment::with('getuser')->where('doctors_id',$doctor_id)
         ->where('prescription_status',1)
         ->get()
         ->map(
            function ($check_prescription ) {
                $birthDate = $check_prescription->getuser->birth_date;
                $years = \Carbon\Carbon::parse( $birthDate)->age;

                $user_name=Client::where('user_id',$check_prescription ->user_id)->first();
                $user_names=Client::where('user_id',$check_prescription ->user_id)->value('full_name');

                if($user_name==null){
                $user_name=trainer::where('user_id',$check_prescription ->user_id)->first();
                $user_names=trainer::where('user_id',$check_prescription ->user_id)->value('name');

                 }
                return[
               'appoinment_id' =>$check_prescription->id,
               'time' =>$check_prescription->time,
               'data' =>$check_prescription->date,
               'name' =>$user_names,
               'years'=> $years,
               ];
              }
              );
              $emptyArray = array();

              if ($check_prescription ) {
                  return response()->json(["viweCreatePrescription"=>$check_prescription ]);
              } else if (!$check_prescription ) {
                  return response()->json($emptyArray,);
              }


    }

    public function CreatePrescription (Request $request){

        $this->validate($request, [

            'doctor_appoinment_id'=>'required|numeric',
            'doctor_note'=>'required'

         ]);

       try {

       $doctor_appoinment_id=$request->doctor_appoinment_id;

        $doctor_appoinment = DoctorAppoinment::where('id',$doctor_appoinment_id)
        ->first(['user_id','doctors_id']);


        $user_id =$doctor_appoinment->user_id;
        $doctor_id=$doctor_appoinment->doctors_id;

        $today = Carbon::today()->toDateString();
        $time = Carbon::today()->now()->format("H:i");
        DB::beginTransaction();
        $Prescription = new Prescription();
        $Prescription->doctor_appoinment_id=$doctor_appoinment_id;
        $Prescription->doctor_note=$request->doctor_note;
        $Prescription->doctor_id=$doctor_id;
        $Prescription->user_id=$user_id;
        $Prescription->time=$time;
        $Prescription->date=$today;
        $Prescription->save();

       $data =$request->medicine_data;

        foreach (  $data as $Prescription_data) {
          $Prescription_datalis = new PrescriptionDetail();
          $Prescription_datalis->doctor_appoinment_id =$doctor_appoinment_id;
          $Prescription_datalis->medicine = $Prescription_data['medicine'];
          $Prescription_datalis->quantity = $Prescription_data['quantity'];
          $Prescription_datalis->save();

        }

        $update_prescription_status=DoctorAppoinment::where('id',$doctor_appoinment_id)->first();
        $update_prescription_status->prescription_status=1;
        $update_prescription_status->update();

        DB::commit();
        return response()->json(['status' => 1,'data' => "Successfully Add"], 200);
        }catch (Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 0,'data' => $e ], 403);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prescription $prescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription)
    {
        //
    }
}
