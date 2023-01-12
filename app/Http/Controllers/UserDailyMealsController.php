<?php

namespace App\Http\Controllers;

use App\Models\DailyMeal;
use App\Models\food_chart;
use Illuminate\Http\Request;
use App\Models\UserDailyMeals;

class UserDailyMealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ViewDailyMeals(Request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
        $date=$request->date;

        $ViewDailyMeals =DailyMeal::join('calorie_counts', 'calorie_counts.id', '=', 'daily_meals.food_id')
              ->where('user_id',$user_id )
              ->where('date',$date)
              ->get(['calorie_counts.*', 'daily_meals.*']);
            

        $emptyArray = array();

        if ($ViewDailyMeals) {
        return response()->json(["ViewDailyMeals"=>$ViewDailyMeals]);
        } else if (!$ViewDailyMeals) {
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
     * @param  \App\Models\UserDailyMeals  $userDailyMeals
     * @return \Illuminate\Http\Response
     */
    public function show(UserDailyMeals $userDailyMeals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserDailyMeals  $userDailyMeals
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDailyMeals $userDailyMeals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserDailyMeals  $userDailyMeals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserDailyMeals $userDailyMeals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserDailyMeals  $userDailyMeals
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDailyMeals $userDailyMeals)
    {
        //
    }
}
