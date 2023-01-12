<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BodyFatManChart;
use App\Models\commonhealthdata;
use App\Models\BodyFatCalculator;
use App\Models\BodyFatWomanChart;
use App\Http\Middleware\AuthenticateUser;

class BodyFatCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewBodyFat(request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];

        $BodyFat=BodyFatCalculator::where('user_id',$user_id)->orderBy('id', 'DESC')->frist(['body_fat','body_fat_result']);

        $emptyArray = array();

        if ($BodyFat) {
            return response()->json(["BodyFat"=>$BodyFat]);
        } else if (!$BodyFat) {
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
    public function BodyFatCalculator(Request $request){



        $this->validate($request, [


             'frontupperarm' => 'required|numeric',
             'backofupperarm' => 'required|numeric',
             'sideofthewaist' => 'required|numeric',
             'backbelowshoulderblade' => 'required|numeric',



        ]);
        try {
            $user_id=$request->user_id;

            $frontupperarm=$request->frontupperarm;
            $backofupperarm=$request->backofupperarm;
            $sideofthewaist=$request->sideofthewaist;
            $backbelowshoulderblade=$request->backbelowshoulderblade;

            if(!$user_id==null){


            $gender=User::where('id', $user_id)->value('gender');
            $birthDate =User::where('id', $user_id)->value('birth_date');
            $currentYear = date('Y'); // Current Year
            $birthYear = date('Y', strtotime($birthDate));
            $age = $currentYear - $birthYear;

            if($gender==null){
            return response()->json(['data' =>"Please Enter Your gender "], 201);
            }

            if($age ==null){
            return response()->json(['data' =>"Please Enter Your birthYear "], 201);
            }

            }else{
                $age = $request->age;
                $gender = $request->gender;
            }

            $search_age=0;

             if ($age >= 16 and $age <=29) {
                $search_age ='AGE_16_29';

            } elseif ($age >=30 and $age <=39) {
                $search_age ='AGE_30_39';
            } elseif ($age >= 40 and $age <=49) {
                $search_age ='AGE_40_49';

            } elseif ($age >= 50) {
                $search_age ='AGE_50';
            }

            $body_fat_a_total_v= $frontupperarm + $backofupperarm + $sideofthewaist + $backbelowshoulderblade;
            $body_fat_a_total_d=$body_fat_a_total_v;
            $body_fat_male_total_d=(int)$body_fat_a_total_d;

            if($body_fat_male_total_d < 201){





            if ($gender == "Male") {

                $body_fats = BodyFatManChart::where('MM', $body_fat_male_total_d)->get('mm');

                if ($body_fats->isEmpty()) {
                    $body_fats[]=$body_fat_male_total_d;

                    foreach ($body_fats as $counts) {
                        for ($j = $counts; $j <=300; $j++) {
                            $body_fats = BodyFatManChart::where('MM', $counts)->get('mm');

                            if (count($body_fats)>0) {
                                $mm_number_up=$body_fats;
                                break;
                            }

                            $counts++;
                        }
                        (int) $x1=$mm_number_up[0]['mm'];

                        $age_number_up = BodyFatManChart::where('MM', $x1)->value($search_age);
                    }
                }
                $body_fatss = BodyFatManChart::where('MM', $body_fat_male_total_d)->get('mm');


                if ($body_fatss->isEmpty()) {
                    $body_fatss[]=$body_fat_male_total_d;

                    foreach ($body_fatss as $countss) {
                        for ($j = $countss; $j <=300; $j--) {
                            $body_fatss = BodyFatManChart::where('MM', $countss)->get('mm');

                            if (count($body_fatss)>0) {
                                $mm_number_down=$body_fatss;

                                break;
                            }
                            $countss--;
                        }
                        (int)$x2=$mm_number_down[0]['mm'];
                        $age_number_down = BodyFatManChart::where('MM', $x2)->value($search_age);
                    }

                    $x=$body_fat_a_total_v;

                    (int) $x1=$mm_number_up[0]['mm'];

                    $age_number_up = BodyFatManChart::where('MM', $x1)->value($search_age);

                    (int)$x2=$mm_number_down[0]['mm'];
                    $age_number_down = BodyFatManChart::where('MM', $x2)->value($search_age);
                    $y1=$age_number_up;
                    $y2=$age_number_down;

                $results= $y1 + ($y2-$y1)/($x2-$x1)*($x-$x1);
                } else {
                $results = BodyFatManChart::where('MM', $body_fat_male_total_d)->value($search_age);
                }


            } elseif ($gender =='Female') {
                $body_fats = BodyFatWomanChart::where('MM', $body_fat_male_total_d)->get('mm');

                if ($body_fats->isEmpty()) {
                    $body_fats[]=$body_fat_male_total_d;

                    foreach ($body_fats as $counts) {
                        for ($j = $counts; $j <=300; $j++) {
                            $body_fats = BodyFatWomanChart::where('MM', $counts)->get('mm');

                            if (count($body_fats)>0) {
                                $mm_number_up=$body_fats;
                                break;
                            }

                            $counts++;
                        }
                        (int) $x1=$mm_number_up[0]['mm'];

                        $age_number_up = BodyFatWomanChart::where('MM', $x1)->value($search_age);
                    }
                }
                $body_fatss = BodyFatWomanChart::where('MM', $body_fat_male_total_d)->get('mm');


                if ($body_fatss->isEmpty()) {
                    $body_fatss[]=$body_fat_male_total_d;

                    foreach ($body_fatss as $countss) {
                        for ($j = $countss; $j <=300; $j--) {
                            $body_fatss = BodyFatWomanChart::where('MM', $countss)->get('mm');

                            if (count($body_fatss)>0) {
                                $mm_number_down=$body_fatss;
                                break;
                            }
                            $countss--;
                        }

                        (int)$x2=$mm_number_down[0]['mm'];
                        $age_number_down = BodyFatWomanChart::where('MM', $x2)->value($search_age);
                    }

                    $x=$body_fat_a_total_v;

                    (int) $x1=$mm_number_up[0]['mm'];

                    $age_number_up = BodyFatWomanChart::where('MM', $x1)->value($search_age);

                    (int)$x2=$mm_number_down[0]['mm'];
                    $age_number_down = BodyFatWomanChart::where('MM', $x2)->value($search_age);
                    $y1=$age_number_up;
                    $y2=$age_number_down;

                    $results= $y1 + ($y2-$y1)/($x2-$x1)*($x-$x1);
                } else {
                    $results  = BodyFatWomanChart::where('MM', $body_fat_male_total_d)->value($search_age);
                }
            }
            if ($gender =='Male') {

                if ($age > 0 and $age <=30) {
                    if ($results >= 9 and $results <=15) {
                        $output = "Good";
                    } elseif ($results >= 15 and $results <=30) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";
                    }else {
                        return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                    }
                } elseif ($age >= 30 and $age <=50) {
                    if ($results > 11 and $results <=17) {
                        $output = "Good";
                    } elseif ($results >= 17 and $results <=30) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";
                    }else {
                        return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                    }

                } elseif ($age <=50) {
                    if ($results >= 12 and $results <=19) {
                        $output = "Good";
                    } elseif ($results >= 19 and $results <=57) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";
                    }else {
                        return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                    }
                }
            } elseif ($gender =='Female') {
                if ($age > 0 and $age <=30) {

                    if ($results >= 14 and $results <=21) {
                        $output = "Good";
                    } elseif ($results >= 15 and $results <=30) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";
                    } elseif ($results <= 14) {
                        $output = "Lean";

                }else {
                    return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                }

                } elseif ($age >= 30 and $age <=50) {
                    if ($results >= 14 and $results <=23) {
                        $output = "Good";
                    } elseif ($results >= 17 and $results <=30) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";

                }else {
                    return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                }
                } elseif ($age <=50) {
                    if ($results >= 16 and $results <=25) {
                        $output = "Good";
                    } elseif ($results >= 19 and $results <=57) {
                        $output = "Above Average";
                    } elseif ($results >= 30 and $results <=300) {
                        $output = "Lean";
                    }
                }else {
                    return response()->json(['data' =>"Please Enter Your Bodyfat  Correct Data"], 201);
                }
            }
            $fat_value = round($results,2);
            if(!$user_id==null){
            $today = Carbon::today()->toDateString();

            $body_fat_calculators = new BodyFatCalculator();
            $body_fat_calculators->user_id=$user_id;
            $body_fat_calculators->front_upper_arm=$frontupperarm;
            $body_fat_calculators->back_of_upper_arm=$backofupperarm;
            $body_fat_calculators->side_of_the_waist=$sideofthewaist;
            $body_fat_calculators->back_below_shoulder_blade=$backbelowshoulderblade;
            $body_fat_calculators->body_fat=$fat_value;
            $body_fat_calculators->body_fat_result=$output;
            $body_fat_calculators->date=$today;
            $body_fat_calculators->save();

            $body_fat_calculators->save();
            return response()->json(['status' => 1,'body_fat'=>$fat_value, 'body_fat_result'=>$output,'data' =>"Successfully Saved"], 201);
            }else{
            return response()->json(['body_fat'=>$fat_value, 'body_fat_result'=>$output], 200);
            }
            }else{
            return response()->json(['status' => 1,'Pleases Enter Correct Data'], 200);
            }

          } catch (Exception $e) {
           return response()->json(['status' => 0,'data' => $e ], 403);
          }

          }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BodyFatCalculator  $bodyFatCalculator
     * @return \Illuminate\Http\Response
     */
    public function show(BodyFatCalculator $bodyFatCalculator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BodyFatCalculator  $bodyFatCalculator
     * @return \Illuminate\Http\Response
     */
    public function edit(BodyFatCalculator $bodyFatCalculator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BodyFatCalculator  $bodyFatCalculator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BodyFatCalculator $bodyFatCalculator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BodyFatCalculator  $bodyFatCalculator
     * @return \Illuminate\Http\Response
     */
    public function destroy(BodyFatCalculator $bodyFatCalculator)
    {
        //
    }
}
