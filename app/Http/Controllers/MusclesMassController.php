<?php

namespace App\Http\Controllers;
use Exception;
use Throwable;
use App\Models\Doctor;
use App\Models\MusclesMass;
use Illuminate\Http\Request;
use App\Models\commonhealthdata;
use App\Models\BodyFatCalculator;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\AuthenticateUser;

class MusclesMassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewMusclesMass(Request $request){


        $userData = $request->get('userData');
        $user_id = $userData['user_id'];

        $MusclesMass=MusclesMass::where('user_id',$user_id)->orderBy('id', 'DESC')->first(['musclemass_value']);

        $emptyArray = array();

        if ($MusclesMass) {
            return response()->json(["MusclesMass"=>$MusclesMass]);
        } else if (!$MusclesMass) {
            return response()->json($emptyArray,);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MusclesMassCalculator()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Muscle_Mass(Request $request){

        $this->validate($request, [
        'user_id'=>'required|numeric',
         ]);

         try{

         $user_id=$request->user_id;
         $chek_user_weight = DB::table('body_parts_measurement_inputers')->where('user_id',$user_id)->value('id');
         //$chek_user_weight=CommonHealthData::where('user_id',$user_id)->get();

        if(!$chek_user_weight==null){

        $weight_data=DB::table('body_parts_measurement_inputers')->where('user_id',$user_id)->orderBy('id', 'desc')->first(['weight','unitweight']);
      //  dd( $weight_data);
        $weight_d=$weight_data->weight;
        $weightunit=$weight_data->unitweight;

        if($weightunit=='LB'){
            $valpounds= $weight_d;
            $kg= $valpounds / 2.20462;
            $weight=round($kg,2);


        }else{
            $weight=$weight_d;
        }
       $body_fat=BodyFatCalculator::where('user_id',$user_id)->orderBy('id', 'desc')->value('body_fat');



       if($body_fat==null){
        return response()->json(['status' => 0,'data' => "Please Update Your body fat"], 403);
       }
        $mid_value= 100-$body_fat;
        $muscle_mass_t= $weight * $mid_value ;
        $muscle_mass=$muscle_mass_t/100;

        $F_muscle_mass=round($muscle_mass,2);

        $MusclesMass_data=new MusclesMass();
        $MusclesMass_data->user_id=$user_id ;
        $MusclesMass_data->musclemass_value=$F_muscle_mass;
        $MusclesMass_data->save();

       return response()->json(['status' => 1,'value'=>$F_muscle_mass,'data' => "Successfully Saved"], 201);

       }else{
       return response()->json(['status' => 0,'data' => "Please Update Your Weight"], 403);
       }

       } catch (Exception $e) {
       return response()->json(['status' => 0,'data' => $e], 403);
        }
       }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MusclesMass  $musclesMass
     * @return \Illuminate\Http\Response
     */
    public function show(MusclesMass $musclesMass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MusclesMass  $musclesMass
     * @return \Illuminate\Http\Response
     */
    public function edit(MusclesMass $musclesMass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MusclesMass  $musclesMass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MusclesMass $musclesMass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MusclesMass  $musclesMass
     * @return \Illuminate\Http\Response
     */
    public function destroy(MusclesMass $musclesMass)
    {
        //
    }
}
