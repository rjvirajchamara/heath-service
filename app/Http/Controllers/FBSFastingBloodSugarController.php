<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthenticateUser;
use Exception;
use Illuminate\Http\Request;
use App\Models\FBSFastingBloodSugar;

class FBSFastingBloodSugarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewBloodSugar(Request $request){


        $userData = $request->get('userData');
        $user_id = $userData['user_id'];

        $Bloodsugar=FBSFastingBloodSugar::where('user_id',$user_id)->orderBy('id', 'DESC')->first(['boodsugarcount','result']);

        $emptyArray = array();

        if ($Bloodsugar) {
            return response()->json(["Bloodsugar"=>$Bloodsugar]);
        } else if (!$Bloodsugar) {
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
    public function boodsugartest(Request $request)
    {
        try {
            
            $boodsugarcount=$request->boodsugarcount;
            $unit = $request->unit;
            $user_id=$request->user_id;

            $fasting="Fasting";
            $after_eating="AfterEating";
            $hours_after_eating="HoursAfterEating";
            $err_message ="Please Enter Correct Data";

            if ($fasting==$unit) {
                if ($boodsugarcount >= 80 and $boodsugarcount <= 100) {
                    $output = "Normal";
                } elseif ($boodsugarcount >= 101 and $boodsugarcount <= 125) {
                    $output = "Impaired Glucose";
                } elseif ($boodsugarcount >= 126) {
                    $output = "Diabetic";
                } else {
                    return response()->json($err_message);
                }
            } elseif ($after_eating==$unit) {
                if ($boodsugarcount >=170 and $boodsugarcount <= 200) {
                    $output = "Normal";
                } elseif ($boodsugarcount >=190 and $boodsugarcount <= 230) {
                    $output = "Impaired Glucose";
                } elseif ($boodsugarcount >=220 and $boodsugarcount <= 300) {
                    $output = "Diabetic";
                } else {
                    return response()->json($err_message);
                }
            } elseif ($hours_after_eating==$unit) {
                if ($boodsugarcount >=120 and $boodsugarcount <= 140) {
                    $output = "Normal";
                } elseif ($boodsugarcount >=140 and $boodsugarcount <= 160) {
                    $output = "Impaired Glucose";
                } elseif ($boodsugarcount <= 200) {
                    $output = "Diabetic";
                } else {
                    return response()->json($err_message);
                }
            } else {
                $output = "Please Enter Correct Data";
            }

            if(!$user_id==null){

            $FBSFastingBloodSugar = new FBSFastingBloodSugar();
            $FBSFastingBloodSugar->user_id=$user_id;
            $FBSFastingBloodSugar->result=$output;
            $FBSFastingBloodSugar->boodsugarcount=$boodsugarcount;
            $FBSFastingBloodSugar ->save();

            return response()->json(['status' => 1,'value'=>$output,'data'  => "Successfully Saved" ], 201);
            }else{
            return response()->json(['status' => 1,'value'=>$output,'data'  => "Successfully" ], 201);
            }

            } catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FBSFastingBloodSugar  $fBSFastingBloodSugar
     * @return \Illuminate\Http\Response
     */
    public function show(FBSFastingBloodSugar $fBSFastingBloodSugar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FBSFastingBloodSugar  $fBSFastingBloodSugar
     * @return \Illuminate\Http\Response
     */
    public function edit(FBSFastingBloodSugar $fBSFastingBloodSugar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FBSFastingBloodSugar  $fBSFastingBloodSugar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FBSFastingBloodSugar $fBSFastingBloodSugar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FBSFastingBloodSugar  $fBSFastingBloodSugar
     * @return \Illuminate\Http\Response
     */
    public function destroy(FBSFastingBloodSugar $fBSFastingBloodSugar)
    {
        //
    }
}
