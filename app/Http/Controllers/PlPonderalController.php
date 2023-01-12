<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\PlPonderal;
use Dotenv\Loader\Resolver;
use Illuminate\Http\Request;
use App\Http\Middleware\AuthenticateUser;
use App\Models\BodyPartsMeasurementInputer;

class PlPonderalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Viewplponderal(Request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];


        $plponderal=PlPonderal::where('user_id',$user_id)->orderBy('id', 'DESC')->first(['pl_value','message']);

        $emptyArray = array();

        if ($plponderal) {
            return response()->json(["plponderal"=>$plponderal]);
        } else if (!$plponderal) {
            return response()->json($emptyArray,);
        }


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
    public function ponderal_index(Request $request){

            $this->validate($request,[
            //'height' =>'required',
            //'weight' =>'required',
           // 'user_id'=>'required|numeric',
            ]);

        try{

            $user_id=$request->user_id;

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
              //  dd($all_height);
            }

        $height2 = ($all_height) * ($all_height) * ($all_height) ;


        $pl  = ( $all_weight / $height2 );

        $rounded_value = round($pl,2);

        $plp = $rounded_value ;
        if ($plp >=8 AND $plp <= 18 ) {
        $output = "Under Weight";
        } else if ($plp >= 11 AND $plp<=15 ) {
        $output = "Normal Weight";
        } else if ($plp >= 15 AND $plp <=17) {
        $output = "Over Weight";
        } else if ($plp>=17) {
        $output = "OBESE";
        }else{

            return response()->json(['data' =>"Please Enter The Correct Date"]);
        }
        if(!$user_id==null){

            $bmi_data= new PlPonderal();
            $bmi_data->user_id=$user_id;
            $bmi_data->pl_value=$rounded_value;
            $bmi_data->message=$output;
            $bmi_data->save();
            //dd([$rounded_value,$output,$user_id]);
      return response()->json(['status' => 1, 'message'=>$output, 'value'=>$rounded_value, 'data' => "Successfully Saved"], 201);
      }else{
        return response()->json(['status' => 1, 'message'=>$output, 'value'=>$rounded_value], 200);
      }
      } catch (Exception $e) {
      return response()->json(['status' => 0,'data' => $e ], 403);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlPonderal  $plPonderal
     * @return \Illuminate\Http\Response
     */
    public function show(PlPonderal $plPonderal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlPonderal  $plPonderal
     * @return \Illuminate\Http\Response
     */
    public function edit(PlPonderal $plPonderal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlPonderal  $plPonderal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlPonderal $plPonderal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlPonderal  $plPonderal
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlPonderal $plPonderal)
    {
        //
    }
}
