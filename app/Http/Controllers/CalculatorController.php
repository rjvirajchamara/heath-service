<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\BmiCalculator;
use App\Models\CommonHealthData;
use App\Http\Middleware\AuthenticateUser;
use App\Models\BodyPartsMeasurementInputer;
use App\Models\PlPonderal;

class CalculatorController extends Controller
{
    public function BmiCalculator(Request $request){

          $user_id=$request->user_id;
          if($user_id==null){

          $this->validate($request, [
         'height_value' =>'required|numeric',
         'weight_value' =>'required|numeric',
         'height_unit' => 'required|string',
         'height_unit' => 'required|string',
          ]);
          }

            try {
            if(!$user_id==null){

            $body_parts_measurement =BodyPartsMeasurementInputer::where('user_id',$user_id)
            ->orderBy('id', 'DESC')->first(['weight','height','unitheight','unitweight','id']);


             $weight_value = $body_parts_measurement->weight;
             $height_value = $body_parts_measurement->height;
             $height_unit =  $body_parts_measurement->unitheight;
             $weight_unit  = $body_parts_measurement->unitweight;

           }else{

            $weight_value = $request->weight_value;
            $height_value = $request->height_value;
            $height_unit = $request->height_unit;
            $weight_unit = $request->weight_unit;

            }

            $pounds = "LB";
            $cm = "CM";
            $foot = "F";
            $kg = "Kg";
            $m = 'M';

            if ($weight_unit == $pounds) {//lbs
                $valpounds = $weight_value;
                $LB = $valpounds / 2.20462;
                $all_weight = round($LB, 2);
            }

            if ($weight_unit == $kg) {//kg
                $valkg = $weight_value;
                $all_weight = $valkg;

            }

            if ($height_unit == $cm) {//cm
                $valcm = $height_value;
                $all_height = $valcm / 100;
                // dd($all_height);
            }

            if ($height_unit == $foot) {//foot
                $valf =  $height_value;
                $valfoot = $valf / 3.2808;
                $all_height = round($valfoot, 2);
                // dd($all_height);
            }

            if ($height_unit == $m) { //meter
                $valm = $height_value;
                $all_height = $valm;
                 //dd($all_height);
            }

            $height2 = ($all_height) * ($all_height);

            $bmi = ($all_weight / $height2);

            $rounded_value = round($bmi, 2);

            $bmi = $rounded_value;
            if ($bmi <= 18.5) {
                $output = "Under Weight" ;
            } elseif ($bmi > 18.5 and $bmi <= 24.9) {
                $output = "Normal Weight";
            } elseif ($bmi > 24.9 and $bmi <= 29.9) {
                $output = "Over Weight";
            } elseif ($bmi > 30.0) {
                $output = "OBESE";
            }

            if(!$user_id==null){
            $bmi_data = new BmiCalculator();
            $bmi_data->user_id = $user_id;
            $bmi_data->bmi_value = $rounded_value;
            $bmi_data->message = $output;
            //dd([$rounded_value,$output,$user_id]);
            $bmi_data->save();

            return response()->json(['status' => 1, 'message'=>$output, 'value'=>$rounded_value, 'data' => "Successfully Saved"], 201);
            } else{

            return response()->json(['status' => 1, 'message'=>$output, 'value'=>$rounded_value, 'data' => "Successfully"],200);
            }
            } catch (Exception $e) {
            return response()->json(['status' => 0, 'data' => $e], 403);
           }
         }


    public function BloodPressureCalculator(Request $request)
    {
    }

    public function BodyFatCalculator(Request $request)
    {
    }

    public function CalorieDBMealfoodcount(Request $request)
    {
    }

    public function BoneDensity(Request $request)
    {
    }

    public function BodyPartsMeasurementInputer(Request $request)
    {
    }

    public function MusclesMass(Request $request)
    {
    }

    public function userCheck(Request $request)
    {
        $userData = $request->get('userData');
        $userId = $userData['user_id'];
        $userRole = $userData['role'][0];

        return $userRole;
    }
}
