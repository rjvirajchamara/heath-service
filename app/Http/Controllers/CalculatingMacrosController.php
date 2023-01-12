<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthenticateUser;
use Exception;
use Carbon\Carbon;
use App\Models\MusclesMass;
use Illuminate\Http\Request;
use App\Models\BodyFatCalculator;
use App\Models\CalculatingMacros;

class CalculatingMacrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewMacros(AuthenticateUser $authenticateUser){


        $user = unserialize($authenticateUser->getUserData());
        $user_id = $user['user_id'];

        $Macros=CalculatingMacros::where('user_id',$user_id)->orderBy('id', 'DESC')->first(['macro_plan_name']);

        $emptyArray = array();

        if ($Macros) {
            return response()->json(["Macros"=>$Macros]);
        } else if (!$Macros) {
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
    public function MacrosCalculator(Request $request){


        $this->validate($request, [
            'x' =>'required',
            'y' =>'required',
            'z' =>'required',
            'user_id'=>'required|numeric',

         ]);

       // try {

            $user_id=$request->user_id;
            $Mass_in_kg_v=MusclesMass::where('user_id', $user_id)->orderBy('id', 'desc')->value('musclemass_value');
            if(!$Mass_in_kg_v==null){

           // $x="Weightloss";
          //  $y="Moderatefitnessprograms";
        // $z="Controlledstylechange";

          $x=$request->x;
          $y=$request->y;
          $z=$request->z;

            // $Mass_in_kg_v=MusclesMass::where('user_id',$user_id)->orderBy('id', 'desc')->first()->musclemass_value;
            // $Mass_in_kg_vlu =$Mass_in_kg_v/1000;

            $mid_value =  (21.6 * $Mass_in_kg_v);
            $minus_values = 370 + $mid_value;
            $x_values = 1.375 * $minus_values;
            $mid_value_formumal_step_ = $x_values*0.7;
            $mid_value_formumal_step_1= round($mid_value_formumal_step_, 2);



            //Step2
            $fitness_program =$mid_value_formumal_step_1 * 1.375;
            $moderate_fitness_program =  $fitness_program * 0.7;

            $intense_personal=$mid_value_formumal_step_1 * 1.55;
            $Intense_personal_training_plan = $intense_personal * 0.7;

            //Step3
            $mid_values=$mid_value_formumal_step_1 * 1.375;
            $x_values=($mid_values) *120/100;
            $moderatefitnessprogram=round($x_values, 2);

            $mid_values=$mid_value_formumal_step_1 * 1.55;
            $x_values=($mid_values) *120/100;
            $Intensepersonaltrainingplan=round($x_values, 2);


            $mid_values=$mid_value_formumal_step_1 * 1.725;
            $x_values=($mid_values) *120/100;
            $HighactiveinlifestyleGymprogram=round($x_values, 2);
            // dd($HighactiveinlifestyleGymprogram);



            if (($x=='Weightloss') and ($y=='Moderatefitnessprograms') and ($z=='Controlledstylechange')) {

                $calorie=$moderate_fitness_program;

                $grams_for_daycho =$moderate_fitness_program * 0.5 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  =$moderate_fitness_program * 0.3 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat =$moderate_fitness_program * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightloss') and ($y=='Moderatefitnessprograms') and ($z=='Acceleratedfatloss')) {

                $calorie=$moderate_fitness_program;

                $grams_for_daycho =$moderate_fitness_program * 0.4 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  =$moderate_fitness_program * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat =$moderate_fitness_program * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightloss') and ($y=='Moderatefitnessprograms') and ($z=='Superacceleratedfatloss')) {

                $calorie=$moderate_fitness_program;

                $grams_for_daycho =$moderate_fitness_program * 0.3 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  =$moderate_fitness_program * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat =$moderate_fitness_program * 0.3 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightloss') and ($y=='Intensepersonaltrainingplan') and ($z=='Controlledstylechange')) {

                $calorie=$Intense_personal_training_plan ;

                $grams_for_daycho = $Intense_personal_training_plan * 0.5 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $Intense_personal_training_plan * 0.3 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $Intense_personal_training_plan * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightloss') and ($y=='Intensepersonaltrainingplan') and ($z=='Acceleratedfatloss')) {


                $calorie=$Intense_personal_training_plan ;

                $grams_for_daycho = $Intense_personal_training_plan * 0.4 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $Intense_personal_training_plan * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $Intense_personal_training_plan * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightloss') and ($y=='Intensepersonaltrainingplan') and ($z=='Superacceleratedfatloss')) {

                $calorie=$Intense_personal_training_plan ;

                $grams_for_daycho = $Intense_personal_training_plan * 0.3 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $Intense_personal_training_plan * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $Intense_personal_training_plan * 0.3 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='weightgain') and ($y=='moderatefitnessprogram') and ($z=='Calsbooster')) {

                $calorie=$moderatefitnessprogram;

                $grams_for_daycho = $moderatefitnessprogram * 0.5 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $moderatefitnessprogram * 0.3 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $moderatefitnessprogram * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightgain') and ($y=='Moderatefitnessprogram') and ($z=='Proteinbooster')) {

                $calorie=$moderatefitnessprogram;

                $grams_for_daycho = $moderatefitnessprogram * 0.4 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $moderatefitnessprogram * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $moderatefitnessprogram * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            // dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightgain') and ($y=='Intensepersonaltrainingplan') and ($z=='Calsbooster')) {

                $calorie=$Intensepersonaltrainingplan;

                $grams_for_daycho = $Intensepersonaltrainingplan * 0.5 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $Intensepersonaltrainingplan * 0.3 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $Intensepersonaltrainingplan * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightgain') and ($y=='Intensepersonaltrainingplan') and ($z=='Proteinbooster')) {

                $calorie=$Intensepersonaltrainingplan;

                $grams_for_daycho = $Intensepersonaltrainingplan * 0.4 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $Intensepersonaltrainingplan * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $Intensepersonaltrainingplan * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            // dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightgain') and ($y=='HighactiveinlifestyleGymprogram') and ($z=='Calsbooster')) {

                $calorie=$HighactiveinlifestyleGymprogram;

                $grams_for_daycho = $HighactiveinlifestyleGymprogram * 0.5 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $HighactiveinlifestyleGymprogram * 0.3 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $HighactiveinlifestyleGymprogram * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } elseif (($x=='Weightgain') and ($y=='HighactiveinlifestyleGymprogram') and ($z=='Proteinbooster')) {

                $calorie = $HighactiveinlifestyleGymprogram;

                $grams_for_daycho = $HighactiveinlifestyleGymprogram * 0.4 / 4;
                $grams_for_day_cho =round($grams_for_daycho, 2);

                $grams_for_protein  = $HighactiveinlifestyleGymprogram * 0.4 / 4;
                $grams_for_day_protein =round($grams_for_protein, 2);

                $grams_for_fat = $HighactiveinlifestyleGymprogram * 0.2 / 9;
                $grams_for_day_fat =round($grams_for_fat, 2);

            //dd($grams_for_day_cho,$grams_for_day_protein ,$grams_for_day_fat);
            } else {
                return response()->json("Please Enter The Correct Date");
            }
            $today = Carbon::today()->toDateString();
            $alculatingMacros = new CalculatingMacros();
            $alculatingMacros->user_id =$user_id;
            $alculatingMacros->carbs = $grams_for_day_cho;
            $alculatingMacros->proteins = $grams_for_day_protein;
            $alculatingMacros->calorie=$calorie;
            $alculatingMacros->fats= $grams_for_day_fat;
            $x=$request->x;
            $y=$request->y;
            $z=$request->z;
            $macro_plan_name=$x." ".$y." ".$z;
            $alculatingMacros->macro_plan_name=$macro_plan_name;
            $alculatingMacros->date=$today;

            $alculatingMacros->save();
            return response()->json(['status' => 1,'value'=>"$macro_plan_name",'data' => "Successfully Saved"], 201);
            }else {
            return response()->json(['data' => "Update MusclesMass"],200);
            }

           // }catch (Exception $e) {
           // return response()->json(['status' => 0,'data' => $e ], 403);
        //}
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalculatingMacros  $calculatingMacros
     * @return \Illuminate\Http\Response
     */
    public function show(CalculatingMacros $calculatingMacros)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalculatingMacros  $calculatingMacros
     * @return \Illuminate\Http\Response
     */
    public function edit(CalculatingMacros $calculatingMacros)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalculatingMacros  $calculatingMacros
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalculatingMacros $calculatingMacros)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalculatingMacros  $calculatingMacros
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalculatingMacros $calculatingMacros)
    {
        //
    }
}
