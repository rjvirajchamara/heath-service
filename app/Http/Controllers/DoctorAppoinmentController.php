<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\trainer;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Else_;
use App\Models\CommonHealthData;
use App\Models\DoctorAppoinment;

class DoctorAppoinmentController extends Controller
{

     public function UserUpcominAppoinment(Request $request){

        $date= Carbon::today()->toDateString();
        $time = Carbon::today()->now()->format("H:i");

        //$userData = $request->get('userData');
        //$user_id = $userData['user_id'];


        $user_id = $request->user_id;


        $UserUpcominAppoinment = DoctorAppoinment::with(['getDoctorDetails.category'])->where('user_id',$user_id)
        ->Where('active',2)
        ->wheredate('date','>=',$date)
        ->orderBy('time','asc')
        ->get()
        ->map(
            function ($UserUpcominAppoinment) {
            return[
              'UserUpcominAppoinment' => $UserUpcominAppoinment,
           ];
        }

        );
        $emptyArray = array();

        if ($UserUpcominAppoinment) {
            return response()->json(["UserUpcominAppoinment" => $UserUpcominAppoinment]);
        } else if (!$UserUpcominAppoinment) {
            return response()->json($emptyArray,);
        }



     }


    public function RescheduleAppoinment(Request $request,$id){

        try {

        $RescheduleAppoinment = DoctorAppoinment::findorfail($id);
        $RescheduleAppoinment->date=$request->date;
        $RescheduleAppoinment->time=$request->time;
        $RescheduleAppoinment->description=$request->description;
        $RescheduleAppoinment->active=4;
        $RescheduleAppoinment->save();

        return response()->json(['status' => 1,'data' => "Successfully  Reschedule"], 200);

        }catch (Exception $e) {
        return response()->json(['status' => 0,'data' => $e ], 403);


        }

    }

    public function CencelAppoinment(Request $request,$id){

        try {

        $RescheduleAppoinment = DoctorAppoinment::findorfail($id);
        $RescheduleAppoinment->description=$request->description;
        $RescheduleAppoinment->active=3;
        $RescheduleAppoinment->save();

        return response()->json(['status' => 1,'data' => "Successfully Cencel"], 200);

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
    public function DoctorAppoinment(Request $request){
        $user_id=0;
        if(!$request->trainer_user_id==null){

         $user_id = $request->trainer_user_id;

        }elseif (!$request->trainer_select_user_id==null) {

        $user_id = $request->trainer_select_user_id;
        }else{


        $userData = $request->get('userData');
        $user_id = $userData['user_id'];


        }

           $this->validate($request, [
            'doctors_id' => 'required',
            'date'=>'required',
            'time'=>'required',
            'doctor_specification'=>'required',
            'language'=>'required',
            'description'=>'required',
            'link'=>'required'

            ]);

        try {

         //if(){

        $check_client_payment=true;
        if($check_client_payment==true){

        $doctorAppoinment = new DoctorAppoinment();
        $doctorAppoinment->user_id=$user_id;
        $doctorAppoinment->doctors_id=$request->doctors_id;
        $doctorAppoinment->date=$request->date;
        $doctorAppoinment->time=$request->time;
        $doctorAppoinment->doctor_specification=$request->doctor_specification;
        $doctorAppoinment->language=$request->language;
        $doctorAppoinment->description=$request->description;
        $doctorAppoinment->active=1;
        $doctorAppoinment->link=$request->link;
        $doctorAppoinment->prescription_status=0;
        $doctorAppoinment->save();

        return response()->json(['status' => 1,'data' => "Successfully Saved"], 201);
       // }else {
       // return response()->json(['status' => 0,'data' => "Successfully Saved"], 201);
       // }
        }else{
        return response()->json(['status' => 0,'data' => "Please Top Your Wallet"], 403);
      }

    } catch (Exception $e) {
        return response()->json(['status' => 0, 'data' => $e], 403);
    }


    }

    public function DoctorViweUserAllHealthData(Request $request){
        //dd($request);

            $user_id = $request->user_id;

      try{
     $user_all_health_data= User::with(['getBmiCalculator', 'getPiPonderal','getBloodPressure'
    ,'getBodyfatCalculator','getBodyPartsMeasurementInputer','getFBSFastingBloodSugar','getMusclesMass'
    ])
    ->where('id', $user_id)
    ->get()
        ->map(
            function ($commonhealthdata) {
                $birthDate = $commonhealthdata->birth_date;
                $years = \Carbon\Carbon::parse( $birthDate)->age;
               $user_name=Client::where('user_id',$commonhealthdata->id)->value('full_name');
                if($user_name==null){
                $user_name =trainer::where('user_id',$commonhealthdata->id)->value('name');
                }
            return[
              'commondata' => $commonhealthdata,
              'user_name' =>$user_name,
              'year'=>$years,

            ];
        }
        );
            return response()->json($user_all_health_data);
          } catch (Exception $e) {
            return response()->json(['status' => 0, 'data' => $e], 403);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorAppoinment  $doctorAppoinment
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorAppoinment  $doctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function DoctorAcceptAppoinment(Request $request,$id){

        try {

            $RescheduleAppoinment = DoctorAppoinment::findorfail($id);
            $RescheduleAppoinment->active=2;
            $RescheduleAppoinment->update();

            return response()->json(['status' => 1,'data' => "Successfully Approval"], 200);

            }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

    }


    }
    public function DoctorcompleteAppoinment(Request $request,$id){

       try {

            $RescheduleAppoinment = DoctorAppoinment::findorfail($id);
            $RescheduleAppoinment->active=5;
            $RescheduleAppoinment->prescription_status=1;
            $RescheduleAppoinment->update();

            return response()->json(['status' => 1,'data' => "Successfully Completet"], 200);

          }catch (Exception $e) {
          return response()->json(['status' => 0,'data' => $e ], 403);

   }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorAppoinment  $doctorAppoinment
     * @return \Illuminate\Http\Response
     */
    public function UpcominAppoinment(Request $request){

        $doctors_id=$request->doctors_id;

        $today = Carbon::today()->toDateString();
        //$time = Carbon::today()->now()->format("H:i");
        //dd($time);

        $UpComingAppointment = DoctorAppoinment::with('getuser')->where('doctors_id',$doctors_id)
         ->where('active',2)
         ->where('date','>=',$today)
         ->where('doctors_id',$doctors_id)
         ->orderBy('date','asc')
         ->orderBy('time','asc')
         ->get()
        ->map(
            function ($UpComingAppointment) {
                $user_name=Client::where('user_id',$UpComingAppointment->user_id)->first();
                $user_names=Client::where('user_id',$UpComingAppointment->user_id)->value('full_name');

                if($user_name==null){
                $user_name=trainer::where('user_id',$UpComingAppointment->user_id)->first();
                $user_names=trainer::where('user_id',$UpComingAppointment->user_id)->value('name');

               //$names = $user_name->name;

                 }
                return[
               'commondata' => $UpComingAppointment,
               'user_data' =>$user_name,
                'name' =>$user_names,


             ];
         }
         );


        return response()->json(['upcomingappointment'=>$UpComingAppointment ]);

    }

    public function ViewpendingAppoinment(Request $request){

        $doctors_id=$request->doctors_id;

        $today = Carbon::today()->toDateString();
        $time = Carbon::today()->now()->format("H:i");

        $ViewpendingAppoinment = DoctorAppoinment::with('getuser')->where('doctors_id',$doctors_id)
        ->where('active',1)
        ->wheredate('date','>=',$today)
        ->where('doctors_id',$doctors_id)
        ->orderBy('time','asc')
        ->get()->map(
            function ($UpComingAppointment) {
               $user_name=Client::where('user_id',$UpComingAppointment->user_id)->first();
                if($user_name==null){
                $user_name =trainer::where('user_id',$UpComingAppointment->user_id)->first();
                }
            return[
              'commondata' => $UpComingAppointment,
              'user_data' =>$user_name,
              //'years'=>$years,

            ];
        }
        );


        return response()->json(['ViewpendingAppoinment'=>$ViewpendingAppoinment]);

    }

    public function ScheduleAppoinment(Request $request){

        $doctors_id=$request->doctors_id;

        $today = Carbon::today()->toDateString();
        $cheduleAppoinment = DoctorAppoinment::where('doctors_id',$doctors_id)
        ->where('active',4)
        ->where('date',$today)
        ->where('doctors_id',$doctors_id)
        ->get();

        return response()->json(['scheduleappoinment'=>$cheduleAppoinment]);



    }


        public function ViewScheduleAndPending(Request $request){

        $doctors_id=$request->doctor_id;

        $Schedule_count = DoctorAppoinment::where('doctors_id',$doctors_id)->where('active',2)->count('id');

        $Pending_count = DoctorAppoinment::where('doctors_id',$doctors_id)->where('active',1)->count('id');


        return response()->json(['Schedule_count'=>$Schedule_count,'Pending_count'=>$Pending_count]);



    }

    public function ScheduleDates(Request $request){

       // $month=Carbon::now()->month;
        $month=$request->month;
        $appoinment_date = DoctorAppoinment::whereMonth('date',$month)->get(['date','time']);

        $emptyArray = array();

       if ($appoinment_date) {
        return response()->json(["appoinment_date"=>$appoinment_date]);
       } else if (!$appoinment_date) {
        return response()->json($emptyArray);
      }

        }

    }

