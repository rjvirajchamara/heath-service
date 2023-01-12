<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthenticateUser;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BodyPartsMeasurementInputer;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\PlPonderalController;

class BodyPartsMeasurementInputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


        public function ViewBodyPartsMeasurement(Request $request){

            $userData = $request->get('userData');
             $user_id = $userData['user_id'];

            $Body_parts_measurement=BodyPartsMeasurementInputer::where('user_id',$user_id)
            ->orderBy('id', 'DESC')
            ->get();

            $emptyArray = array();

            if ($Body_parts_measurement) {
                return response()->json(["Body_parts_measurement"=>$Body_parts_measurement]);
            } else if (!$Body_parts_measurement) {
                return response()->json($emptyArray,);
            }


        }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function BodyPartsMeasurement(Request $request)
    {
        try {
            $this->validate($request, [
                'user_id'=>'required|numeric',
                'bust' => 'required|numeric',
                'stomach' => 'required|numeric',
                'chest' => 'required|numeric',
                'calves' => 'required|numeric',
                'hips' => 'required|numeric',
                'weight' => 'required|numeric',
                'arm'=>'required|numeric',
                'thighs'=>'required|numeric',
                'height'=>'required|numeric',
                'bustunit' => 'required',
                'stomachunit' => 'required',
                'chestunit' => 'required',
                'calvesunit' => 'required',
                'hipsunit' => 'required',
                'weightunit' => 'required',
                'armunit'=>'required',
                'thighsunit'=>'required',
                'heightunit'=>'required',
            ]);
           $user_id=$request->user_id;
           $today = Carbon::today()->toDateString();

            $bodiparts_measurement= new BodyPartsMeasurementInputer();
            $bodiparts_measurement->user_id=$user_id;
            $bodiparts_measurement->bust=$request->bust;
            $bodiparts_measurement->stomach=$request->stomach;
            $bodiparts_measurement->chest=$request->chest;
            $bodiparts_measurement->calves=$request->calves;
            $bodiparts_measurement->hips=$request->hips;
            $bodiparts_measurement->weight=$request->weight;
            $bodiparts_measurement->arm=$request->arm;
            $bodiparts_measurement->thighs=$request->thighs;
            $bodiparts_measurement->height=$request->height;
            $bodiparts_measurement->unitbust=$request->bustunit;
            $bodiparts_measurement->unitstomach=$request->stomachunit;
            $bodiparts_measurement->unitchest=$request->chestunit;
            $bodiparts_measurement->unitcalves=$request->calvesunit;
            $bodiparts_measurement->unithips=$request->hipsunit;
            $bodiparts_measurement->unitweight=$request->weightunit;
            $bodiparts_measurement->unitarm=$request->armunit;
            $bodiparts_measurement->unitheight=$request->heightunit;
            $bodiparts_measurement->unitthighs=$request->thighsunit;

            $bodiparts_measurement->date=$today;

            if ($bodiparts_measurement->save()) {

                $CalculatorController = new CalculatorController;
                $CalculatorController->BmiCalculator($request);

                $PlPonderalController = new PlPonderalController;
                $PlPonderalController->ponderal_index($request);

                return response()->json(['status' => 1,'data' => "Successfully Saved"], 201);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);
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
     * @param  \App\Models\BodyPartsMeasurementInputer  $bodyPartsMeasurementInputer
     * @return \Illuminate\Http\Response
     */
    public function show(BodyPartsMeasurementInputer $bodyPartsMeasurementInputer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BodyPartsMeasurementInputer  $bodyPartsMeasurementInputer
     * @return \Illuminate\Http\Response
     */
    public function edit(BodyPartsMeasurementInputer $bodyPartsMeasurementInputer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BodyPartsMeasurementInputer  $bodyPartsMeasurementInputer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BodyPartsMeasurementInputer $bodyPartsMeasurementInputer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BodyPartsMeasurementInputer  $bodyPartsMeasurementInputer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BodyPartsMeasurementInputer $bodyPartsMeasurementInputer)
    {
        //
    }
}
