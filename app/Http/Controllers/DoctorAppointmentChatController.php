<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AppoinmentMessage;
use App\Models\Doctor;
use App\Models\DoctorAppointmentChat;
use GrahamCampbell\ResultType\Result;

class DoctorAppointmentChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Message(Request $request){

        //$message->chatroom_id

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
    public function AppoinmentMessage(Request $request){

        $doctors_id=$request->doctors_id;
        $user_id=$request->user_id;
        $chat_id =$request->chat_id;
        $name = $request->name;


       try {

        if(!$user_id==null){

        if( $chat_id == null ){

        $check_chat = DoctorAppointmentChat::where('doctors_id',$doctors_id)
        ->where('user_id',$user_id)->value('id');


        if($check_chat == null){

        $doctorappointmentchat = new DoctorAppointmentChat();
        $doctorappointmentchat->doctors_id=$doctors_id;
        $doctorappointmentchat->user_id=$user_id;
        $doctorappointmentchat->save();
        }
    }
        $today = Carbon::today()->toDateString();

        $time = Carbon::now()->toTimeString();




        $chat_id = DoctorAppointmentChat::where('doctors_id',$doctors_id)
        ->where('user_id',$user_id)->value('id');




        $appoinment_messages = new  AppoinmentMessage();
        $appoinment_messages->doctor_appointment_chats_id = $chat_id ;
        $appoinment_messages->massage = $request->massage;
        $appoinment_messages->date =$today;
        $appoinment_messages->time =$time;
        $appoinment_messages->name = $name;
        $appoinment_messages->save();

        return response()->json(['status' => 1,'data' => "Successfully save"], 200);
       }else{


       }
       }catch (Exception $e) {
        return response()->json(['status' => 0,'data' => $e ], 403);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorAppointmentChat  $doctorAppointmentChat
     * @return \Illuminate\Http\Response
     */
    public function Showchatlist(Request $request){


        $userData = $request->get('userData');
        $user_id = $userData['user_id'];

        $doctor_id = DoctorAppointmentChat::where('user_id',$user_id )->get('doctors_id');

        if(count($doctor_id) > 0){


        foreach ($doctor_id as $doctor_ids) {

        $chat_list[] = Doctor::where('id',$doctor_ids->doctors_id)->get(['id','name']);

        }
        return response()->json([$chat_list]);
        }
        $emptyArray = array();

        return response()->json($emptyArray);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorAppointmentChat  $doctorAppointmentChat
     * @return \Illuminate\Http\Response
     */
    public function ShowcMessage(Request $request){

        $chat_id=$request->chat_id;
        $massage = AppoinmentMessage::where('doctor_appointment_chats_id',$chat_id)
        ->orderBy('id', 'DESC')->get(['massage','date','time','name']);

        $emptyArray = array();

        if ($massage) {
         return response()->json([$massage]);
        } else if (!$massage) {
         return response()->json($emptyArray);
       }

         }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorAppointmentChat  $doctorAppointmentChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorAppointmentChat $doctorAppointmentChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorAppointmentChat  $doctorAppointmentChat
     * @return \Illuminate\Http\Response
     */
   public function DeleteChat($id){
      try{
      $chat_id=AppoinmentMessage::where('doctor_appointment_chats_id',$id)->get();
      foreach ($chat_id as  $ids) {
            $Message = AppoinmentMessage::findorfail($ids->id);
            $Message->delete();

        }
       return response()->json(['status' => 1,'data' => "Successfully Deleted"], 204);
       } catch (Exception $e) {return response()->json(['status' => 0,'data' => $e], 403);
         }
           }

}
