<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClientTrainer;
use App\Models\Client_Trainer;
use App\Models\CommonHealthData;
use App\Http\Middleware\AuthenticateUser;

class CommonHealthDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    public function viewCommonHealthData(Request $request){

        $trainer_id=$request->trainer_id;

        try {

       $client_id = ClientTrainer::where('trainer_id',$trainer_id)->get('client_id');


       if(empty($client_id->isEmpty())){

       foreach ($client_id as $client_id) {
       $user_id=$client_id->client_id;


       $all_health_data[] = User::with(['getBmiCalculator', 'getPiPonderal','getBloodPressure','getMacros'
       ,'getBodyfatCalculator','getBodyPartsMeasurementInputer','getFBSFastingBloodSugar','getMusclesMass'
       ,'getCalorieCount'])->get()
       ->where('id',$user_id)
           ->map(
               function ($commonhealthdata) {
               return[
                 'commonhealthdata' => $commonhealthdata,
        
               ];
           }

           );

           }

          return response()->json($all_health_data);
          }else{
          $emptyArray = array();
          return response()->json($emptyArray);
        }
        } catch (Exception $e) {
        return response()->json(['status' => 0, 'data' => $e], 403);
       }
    }
    public function viewUserCommonHealthData(Request $request)
    {
        try {
            $userData = $request->get('userData');
            $user_id = $userData['user_id'];

     $user_all_health_data = User::with(['getBmiCalculator','getBloodPressure','getMacros'
    ,'getBodyfatCalculator','getBodyPartsMeasurementInputer','getFBSFastingBloodSugar','getMusclesMass'
    ])
    ->where('id', $user_id)
    ->get()
        ->map(
            function ($commonhealthdata) {
            return[
              'commondate' => $commonhealthdata,
              //'description'=>$commonhealthdata->libraries->description,
             // 'count'=>$commonhealthdata->libraries->count,
             // 'duration'=>$commonhealthdata->libraries->duration,
            //  'libraries_icons'=>$commonhealthdata->libraries->libraries_icons,

            ];
        }
        );

            return response()->json($user_all_health_data);
          } catch (Exception $e) {
            return response()->json(['status' => 0, 'data' => $e], 403);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TrainerSearchUserHelthData(Request $request,$id)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function StoreUserCommonHealthData(Request $request)
    {
        try {
            $user_id=$request->user_id;

            $this->validate($request, [
            'user_id'=>'required|numeric',
            'height' =>'required',
            'weight' =>'required',
            'weightunit' =>'required',
            'heightunit' =>'required',

            ]);

            $commonhealthdata = new CommonHealthData();
            $commonhealthdata->user_id=$user_id;
            $commonhealthdata->user_original_id=$user_id;
            $commonhealthdata->weight=$request->weight;
            $commonhealthdata->height=$request->height;
            $commonhealthdata->weightunit=$request->weightunit;
            $commonhealthdata->heightunit=$request->heightunit;
            $commonhealthdata->save();

            return response()->json(['status' => 1,'data' => "Successfully Saved"], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'data' => $e], 403);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommonHealthData  $commonHealthData
     * @return \Illuminate\Http\Response
     */
    public function show(CommonHealthData $commonHealthData)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CommonHealthData  $commonHealthData
     * @return \Illuminate\Http\Response
     */
    public function edit(CommonHealthData $commonHealthData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommonHealthData  $commonHealthData
     * @return \Illuminate\Http\Response
     */
    public function UpdateUserCommonHealthData(Request $request, AuthenticateUser $authenticateUser)
    {
        try {
            $user = unserialize($authenticateUser->getUserData());
            $user_id = $user['user_id'];



            return response()->json(['status' => 1,'data' => "Successfully Saved"], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'data' => $e], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CommonHealthData  $commonHealthData
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommonHealthData $commonHealthData)
    {
        //
    }
}
