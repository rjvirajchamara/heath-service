<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BmiCalculator;
use App\Http\Middleware\AuthenticateUser;
use GrahamCampbell\ResultType\Result;
use Illuminate\Support\Facades\Http;

class BmiCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewBmi(Request $request){

       // dd($request);

        $userData = $request->get('userData');
        $id = $userData['user_id'];

        //$BearerToken = $request->bearerToken();
        //$collection = Http::withHeaders(['Authorization'=>$BearerToken])->get
        //('https://ion-groups.live/api/users/profiles/3');
        //dd($collection);

        $bmi=BmiCalculator::where('user_id',$id)->orderBy('id', 'DESC')->first(['bmi_value','message']);

        $emptyArray = array();

        if ($bmi) {
            return response()->json(["Bmi"=>$bmi]);
        } else if (!$bmi) {
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BmiCalculator  $bmiCalculator
     * @return \Illuminate\Http\Response
     */
    public function show(BmiCalculator $bmiCalculator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BmiCalculator  $bmiCalculator
     * @return \Illuminate\Http\Response
     */
    public function edit(BmiCalculator $bmiCalculator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BmiCalculator  $bmiCalculator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BmiCalculator $bmiCalculator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BmiCalculator  $bmiCalculator
     * @return \Illuminate\Http\Response
     */
    public function destroy(BmiCalculator $bmiCalculator)
    {
        //
    }
}
