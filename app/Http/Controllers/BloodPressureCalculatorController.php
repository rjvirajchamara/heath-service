<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthenticateUser;
use Exception;
use Illuminate\Http\Request;
use App\Models\BloodPressureCalculator;
use App\Models\Doctor;
use Carbon\Carbon;

class BloodPressureCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewBloodPressure(Request $request){

          $userData = $request->get('userData');
          $user_id = $userData['user_id'];

        $bloodpressure=BloodPressureCalculator::where('user_id',$user_id)->orderBy('id', 'DESC')->value('blood_pressure_result');

        $emptyArray = array();

        if ($bloodpressure) {
            return response()->json(["BloodPressure"=>$bloodpressure]);
        } else if (!$bloodpressure) {
            return response()->json($emptyArray,);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BloodPressureCheck(Request $request){
           try {

            $this->validate($request, [
            'Systopic_mm_Hg' =>'required|numeric',
            'lastolio_mm_Hg' =>'required|numeric',
            ]);

            $Systopic_mm_Hg=$request->Systopic_mm_Hg;
            $Dlastolio_mm_Hg=$request->lastolio_mm_Hg;
            $user_id=$request->user_id;
            $NormalSystopic=120;
            $NormalDlastolio=80;
            $ElevatedlSystopic=129;
            $ElevatedDlastolio=80;
            $HighBloodPressureSystopic=139;
            $HighBloodPressureDlastolio=89;
            $HighBloodPressureStage2Systopic=179;
            $HighBloodPressureStage2Dlastolio=90;
            $HypertensiveCrisisSystopic=180;
            $HypertensiveCrisisDlastolio=120;
            //$user_id=1;

            if ($NormalSystopic >= $Systopic_mm_Hg &&  $NormalDlastolio >= $Dlastolio_mm_Hg) {
                $result='Normal';
            //dd($t);
            } elseif (($ElevatedlSystopic >= $Systopic_mm_Hg) && ($ElevatedDlastolio >= $Dlastolio_mm_Hg)) {
                //return response()->json('Elevated');
                $result='Elevated';
            } elseif (($HighBloodPressureSystopic>= $Systopic_mm_Hg)&& ($HighBloodPressureDlastolio>= $Dlastolio_mm_Hg)) {
                //return response()->json('High Blood Pressure (Hypertension) Stage 1');
                $result='High Blood Pressure (Hypertension) Stage 1';
            } elseif (($HighBloodPressureStage2Systopic>= $Systopic_mm_Hg) || ($HighBloodPressureStage2Dlastolio >= $Dlastolio_mm_Hg)) {
                //return response()->json('High Blood Pressure (Hypertension) Stage 2');
                $result='High Blood Pressure (Hypertension) Stage 2';
            } elseif (($HypertensiveCrisisSystopic<=$Systopic_mm_Hg)  ||  ($HypertensiveCrisisDlastolio<=$Dlastolio_mm_Hg)) {
                //return response()->json('Hypertensive Crisis (consult your doctor immediately)');
                $result='Hypertensive crisis(contact your doctor immediately)';
            } else {
                return response()->json('Pleases Enter Correct Data');
            }
            if(!$user_id==null){
            $today = Carbon::today()->toDateString();

            $BloodPressure = new BloodPressureCalculator();
            $BloodPressure->user_id=$user_id;
            $BloodPressure->systopic_mm_Hg=$Systopic_mm_Hg;
            $BloodPressure->lastolio_mm_Hg=$Dlastolio_mm_Hg;
            $BloodPressure->blood_pressure_result=$result;
            $BloodPressure->date=$today;
            $BloodPressure->save();

           return response()->json(['status' => 1,'value' => $result,'data' => "Successfully Saved"], 201);

            }else{
            return response()->json(['status' => 1,'value' => $result], 200);
            }
        } catch (Exception $e) {
          return response()->json(['status' => 0,'data' => $e], 403);
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
     * @param  \App\Models\BloodPressureCalculator  $bloodPressureCalculator
     * @return \Illuminate\Http\Response
     */
    public function show(BloodPressureCalculator $bloodPressureCalculator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BloodPressureCalculator  $bloodPressureCalculator
     * @return \Illuminate\Http\Response
     */
    public function edit(BloodPressureCalculator $bloodPressureCalculator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BloodPressureCalculator  $bloodPressureCalculator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BloodPressureCalculator $bloodPressureCalculator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BloodPressureCalculator  $bloodPressureCalculator
     * @return \Illuminate\Http\Response
     */
    public function destroy(BloodPressureCalculator $bloodPressureCalculator)
    {

    }


}
