<?php

namespace App\Http\Controllers;

use App\Models\CalorieCount;
use App\Models\food_chart;
use Illuminate\Http\Request;

class FoodChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AdminViweFood(){

     $show_all_food= CalorieCount::where('active',1)->get();

     $emptyArray = array();

     if ($show_all_food) {
     return response()->json(["show_all_food"=>$show_all_food]);
     } else if (!$show_all_food) {
     return response()->json($emptyArray,);
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function ClientViweFood(Request $request){
        $CountryCode=$request->countryCode;
        $show_all_food= CalorieCount::where('active',1)->where('country_code',$CountryCode)->get();

        $emptyArray = array();

        if ($show_all_food) {
        return response()->json(["show_all_food"=>$show_all_food]);
        } else if (!$show_all_food) {
        return response()->json($emptyArray,);
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
     * @param  \App\Models\food_chart  $food_chart
     * @return \Illuminate\Http\Response
     */
    public function Food(food_chart $food_chart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\food_chart  $food_chart
     * @return \Illuminate\Http\Response
     */
    public function EditFood(food_chart $food_chart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\food_chart  $food_chart
     * @return \Illuminate\Http\Response
     */
    public function ApprovelFood(Request $request, food_chart $food_chart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\food_chart  $food_chart
     * @return \Illuminate\Http\Response
     */
    public function DestroyFood(food_chart $food_chart)
    {
        //
    }
}
