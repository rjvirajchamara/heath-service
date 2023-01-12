<?php

namespace App\Http\Controllers;

use tidy;
use Exception;
use Carbon\Carbon;
use App\Models\DailyMeal;
use App\Models\temporary;
use PHPUnit\Util\Printer;
use App\Models\CalorieCount;
use Illuminate\Http\Request;
use App\Models\ClientTrainer;
use App\Models\Client_Trainer;
use App\Models\CalculatingMacros;
use Illuminate\Support\Facades\DB;
use App\Models\NutritionComponents;
use GrahamCampbell\ResultType\Result;
use App\Http\Middleware\AuthenticateUser;
use App\Models\TrainerViweAllUserCalorieCount;

class CalorieCountController extends Controller
{
    public function create_daily_meal(Request $request){


        $this->validate($request, [
            'foodid' =>'required',
            'potion' =>'required'
         ]);

      try {

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
        $country_code = $request->country_code;

        $today = Carbon::today()->toDateString();
        $food_id=$request->foodid;
        $potion=$request->potion;

        $macros_carbs = CalculatingMacros::where('user_id', $user_id)->orderBy('id', 'DESC')->value('id');
        if(!$macros_carbs==null){



        $DailyMeal = new DailyMeal();
        $DailyMeal->user_id=$user_id;
        $DailyMeal->food_id=$food_id;
        $DailyMeal->potion=$potion;
        $DailyMeal->date=$today;
        $DailyMeal->country_code=$country_code;
        $DailyMeal->save();

        $check_nutritioncomponents=NutritionComponents::where('user_id', $user_id)->where('date',$today)->value("id");


        if($check_nutritioncomponents == null){

        $food_date=CalorieCount::where('id',$food_id)->first(['fat_g','carbohydrates_g','protrien_g','calories']);

        $fat = $potion * $food_date->fat_g;
        $carbohydrates = $potion * $food_date->carbohydrates_g;
        $protrien = $potion * $food_date->protrien_g;
        $calorie = $potion * $food_date->calories;



        $NutritionComponents = new NutritionComponents();
        $NutritionComponents->user_id=$user_id;
        $NutritionComponents->protrien_g=$protrien;
        $NutritionComponents->carbohydrates_g=$carbohydrates;
        $NutritionComponents->fat_g=$fat;
        $NutritionComponents->date=$today;
        $NutritionComponents->calorie=$calorie;
        $NutritionComponents->save();
        $this->CalorieCountCalculation($request);
        }else{

        $food_date=CalorieCount::where('id',$food_id)->first(['fat_g','carbohydrates_g','protrien_g','calories']);
        $fat = $potion * $food_date->fat_g;
        $carbohydrates = $potion * $food_date->carbohydrates_g;
        $protrien = $potion * $food_date->protrien_g;
        $calorie = $potion * $food_date->calories;


        $id=NutritionComponents::where('user_id', $user_id)->where('date',$today)->value('id');

        $all_food_date=NutritionComponents::where('user_id', $user_id)->where('date',$today)
        ->first(['fat_g','carbohydrates_g','protrien_g','calorie']);


        $fats = $fat + $all_food_date->fat_g;

        $carbohydratess = $carbohydrates + $all_food_date->carbohydrates_g;
        $protriens = $protrien  + $all_food_date->protrien_g;
        $calories = $calorie + $all_food_date->calorie;



        $NutritionComponents = NutritionComponents::findorfail($id);
        $NutritionComponents->user_id=$user_id;
        $NutritionComponents->protrien_g=$protriens ;
        $NutritionComponents->carbohydrates_g=$carbohydratess;
        $NutritionComponents->fat_g=$fats;
        $NutritionComponents->calorie=$calories;
        $NutritionComponents->date=$today;
        $NutritionComponents->save();
        $this->CalorieCountCalculation($request);

        }

       return response()->json(['status' => 1,  'data' => "Successfully Saved"], 201);

       }else {
        return response()->json(['status' => 0,'data' => 'Please Select Macros Program']);

       }
       }


       catch (Exception $e) {
      return response()->json(['status' => 0, 'data' => $e], 403);
       }
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CalorieCountCalculation(Request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
        try {

        $today = Carbon::today()->toDateString();
        $check_dailymeal=DailyMeal::where('user_id', $user_id)->where('date',$today)->value("id");




        if($check_dailymeal){

        $macros_carbs = CalculatingMacros::where('user_id', $user_id)->orderBy('id', 'DESC')->value('carbs');
        $macros_proteins = CalculatingMacros::where('user_id', $user_id)->orderBy('id', 'DESC')->value('proteins');
        $macros_fats = CalculatingMacros::where('user_id', $user_id)->orderBy('id', 'DESC')->value('fats');
        $macros_calories = CalculatingMacros::where('user_id', $user_id)->orderBy('id', 'DESC')->value('calorie');


        $today = Carbon::today()->toDateString();

        $all_food_date=NutritionComponents::where('user_id', $user_id)->where('date',$today)->first(['fat_g','carbohydrates_g','protrien_g','calorie']);

        $fats = $macros_fats - $all_food_date->fat_g;
        $carbohydratess = $macros_carbs  - $all_food_date->carbohydrates_g;
        $protriens =  $macros_proteins -$all_food_date->protrien_g;
        $calories = $macros_proteins -$all_food_date->calories;

        $check_temporary=temporary::where('user_id', $user_id)->where('today',$today)->value("id");


        if($check_temporary == null){

            $temporariesmeal = new temporary();
            $temporariesmeal->user_id=$user_id;
            $temporariesmeal->today=$today;
            $temporariesmeal->fat_g=$fats;
            $temporariesmeal->carbohydrates_g=$carbohydratess;
            $temporariesmeal->protrien_g=$protriens;
            $temporariesmeal->calorie=$calories;
            $temporariesmeal->save();

        }else{

            $id=temporary::where('user_id', $user_id)->where('today',$today)->value('id');

            $temporariesmeal = temporary::findorfail($id);
            $temporariesmeal->fat_g=$fats;
            $temporariesmeal->carbohydrates_g=$carbohydratess;
            $temporariesmeal->protrien_g=$protriens;
            $temporariesmeal->calorie=$calories;
            $temporariesmeal->save();

            }
            $All_NutritionComponents=NutritionComponents::where('user_id', $user_id)->where('date',$today)->first(['fat_g','carbohydrates_g','protrien_g','calorie']);

            $carbs_s=$All_NutritionComponents->carbohydrates_g/$macros_carbs * 100 ;
            $carbs_percentage=round($carbs_s,0);

            $fat_s=$All_NutritionComponents->fat_g/$macros_fats * 100;
            $fat_percentage=round($fat_s,0);

            $protrien_s=$All_NutritionComponents->protrien_g/$macros_proteins * 100;
            $protrien_percentage=round($protrien_s,0);

            ($calorie_s=$All_NutritionComponents->calorie/$macros_calories* 100);
            $calorie_percentage=round($calorie_s,0);

            $carbohydrates=$All_NutritionComponents->carbohydrates_g;
            $fat=$All_NutritionComponents->fat_g;
            $protrien=$All_NutritionComponents->protrien_g;
            $calorie=$All_NutritionComponents->calorie;

            $id=TrainerViweAllUserCalorieCount::where('user_id', $user_id)->where('date', $today)->value('id');

            if($id==null){

            $trainer_view_caloriecount = new TrainerViweAllUserCalorieCount();
            $trainer_view_caloriecount->user_id =$user_id;
            $trainer_view_caloriecount->date= $today;
            $trainer_view_caloriecount->fat_g =$fat;
            $trainer_view_caloriecount->carbohydrates_g = $carbohydrates;
            $trainer_view_caloriecount->protrien_g = $protrien;
            $trainer_view_caloriecount->calorie =  $calorie;
            $trainer_view_caloriecount->percentage_fat_g =$fat_percentage;
            $trainer_view_caloriecount->percentage_carbohydrates_g = $carbs_percentage;
            $trainer_view_caloriecount->percentage_protrien_g = $protrien_percentage;
            $trainer_view_caloriecount->percentage_calorie_g = $calorie_percentage;
            $trainer_view_caloriecount->target_protrien_g = $protriens;
            $trainer_view_caloriecount->target_fat_g=$fats;
            $trainer_view_caloriecount->target_carbohydrates_g=$carbohydratess;
            $trainer_view_caloriecount->target_percentage_calorie_g=$calories;
            $trainer_view_caloriecount->save();

            }else {
                $insert_data=TrainerViweAllUserCalorieCount::where('user_id', $user_id)
                ->where('date', $today)->first();
                $insert_data_fat_g=$insert_data->fat_g;
                $insert_data_carbohydrates_g=$insert_data->carbohydrates_g;
                $insert_data_protrien_g=$insert_data->protrien_g;
                $insert_data_calorie=$insert_data->calorie;
                $insert_data_percentage_fat_g=$insert_data->percentage_fat_g;
                $insert_data_percentage_carbohydrates_g=$insert_data->percentage_carbohydrates_g;
                $insert_data_percentage_protrien_g=$insert_data->percentage_protrien_g;
               $insert_data_percentage_calorie_g=$insert_data->percentage_calorie_g;
               $insert_datat_arget_protrien_g=$insert_data->target_protrien_g;
               $insert_data_target_fat_g=$insert_data->target_fat_g;
               $insert_data_target_carbohydrates_g=$insert_data->target_carbohydrates_g;
               $insert_data_target_percentage_calorie_g=$insert_data->target_percentage_calorie_g;


                $trainer_view_caloriecount = TrainerViweAllUserCalorieCount::findorfail($id);;

                $trainer_view_caloriecount->fat_g =$fat+$insert_data_fat_g;
                $trainer_view_caloriecount->carbohydrates_g = $carbohydrates+$insert_data_carbohydrates_g;
                $trainer_view_caloriecount->protrien_g = $protrien+$insert_data_protrien_g;
                $trainer_view_caloriecount->calorie = $calorie+$insert_data_calorie;
                $trainer_view_caloriecount->percentage_fat_g =$fat_percentage+$insert_data_percentage_fat_g;
                $trainer_view_caloriecount->percentage_carbohydrates_g = $carbs_percentage + $insert_data_percentage_carbohydrates_g;
                $trainer_view_caloriecount->percentage_protrien_g = $protrien_percentage+$insert_data_percentage_protrien_g;
                $trainer_view_caloriecount->percentage_calorie_g = $calorie_percentage+$insert_data_percentage_calorie_g;
                $trainer_view_caloriecount->target_protrien_g = $protriens+ $insert_datat_arget_protrien_g;
                $trainer_view_caloriecount->target_fat_g=$fats-$insert_data_target_fat_g;
                $trainer_view_caloriecount->target_carbohydrates_g=$carbohydratess-$insert_data_target_carbohydrates_g;
                $trainer_view_caloriecount->target_percentage_calorie_g=$calories-$insert_data_target_percentage_calorie_g;
                $trainer_view_caloriecount->save();

            }


            }

    } catch (Exception $e) {
        return response()->json(['status' => 0, 'data' => $e], 403);
      }
    }

    public function ClientViewCalorieCount(Request $request){
        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
        $date = $request->date;


        $All_CalorieCount_data =TrainerViweAllUserCalorieCount::with(['getmacros'])->where('user_id',$user_id)->
        where('date','=',$date)->orderBy('id', 'DESC')->first();

        $emptyArray = array();
       if ($All_CalorieCount_data) {

        return response()->json(["AllCalorieCountData"=>$All_CalorieCount_data ]);
        } else{
        return response()->json(["AllCalorieCountData"=>$emptyArray]);
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function InsertFood(Request $request){

        $userData = $request->get('userData');
        $user_id = $userData['user_id'];
        $country_code = $request->country_code;


        $this->validate($request, [
            'name' =>'required',
            'av_potlon' =>'required',
            'calories' =>'required',
            'fat_g' =>'required',
            'saturated_fat_g' =>'required',
            'carbohydrates_g' =>'required',
            'protrien_g' =>'required',
            'fiber_g' =>'required',


         ]);

         try {

        $Foodname=$request->name;
        $check_food_name = CalorieCount::where('country_code',$country_code)->where('name', 'LIKE',"$Foodname")->value('name');


        if($check_food_name == null){

         $InsertFood = new CalorieCount();
         $InsertFood->name=$request->name;
         $InsertFood->av_potlon=$request->av_potlon;
         $InsertFood->calories=$request->calories;
         $InsertFood->fat_g=$request->fat_g;
         $InsertFood->saturated_fat_g=$request->saturated_fat_g;
         $InsertFood->carbohydrates_g=$request->carbohydrates_g;
         $InsertFood->protrien_g=$request->protrien_g;
         $InsertFood->fiber_g=$request->fiber_g;
         $InsertFood->country_code=$country_code;
         $InsertFood->food_category_id=$request->food_category_id;
         $InsertFood->insert_user_id= $user_id;

         $userRole = $userData['role'][0];
         if($userRole == 'admin'){
         $InsertFood->active=1;
         } else{
         $InsertFood->active=0;
         }
         $InsertFood->save();


        return response()->json(['status' => 1,  'data' => "Successfully Saved"], 201);

        }else{

        return response()->json(['status' => 0,  'data' => "Already Add "], 403);
        }

        } catch (Exception $e) {
          return response()->json(['status' => 0, 'data' => $e], 403);
        }

    }
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     *
     */

    public function Myfood(Request $request ){
        $user_id = $request->user_id;

        $my_food =CalorieCount::where('insert_user_id',$user_id)->get();

        $emptyArray = array();

        if ($my_food) {
            return response()->json(["my_food"=>$my_food]);
        } else if (!$my_food) {
            return response()->json($emptyArray);
        }


        }

        public function Suggestionfood(Request $request ){
            $user_id = $request->user_id;

            $my_food =DailyMeal::where('user_id',$user_id)->orderBy('id', 'DESC')->get('food_id');

            if(!$my_food->isEmpty()){

            foreach ($my_food  as $key => $my_food) {

           $Suggestionfood[]=CalorieCount::where('id',$my_food->food_id)->get();
           if($key==4){
               break;
           }


                # code...
            }

        }else {
            $Suggestionfood[]= array();
        }


            $emptyArray = array();

            if ($Suggestionfood) {
                return response()->json(["Suggestionfood"=>$Suggestionfood]);
            } else if (!$Suggestionfood) {
                return response()->json($emptyArray);
            }


            }


    public function foodupdate(Request $request ,$id){


       // $userData = $request->get('userData');
       // $user_id = $userData['user_id'];
       $country_code = $request->country_code;


        $this->validate($request, [
           'name' =>'required',
           'av_potlon' =>'required',
           'calories' =>'required',
           'fat_g' =>'required',
           'saturated_fat_g' =>'required',
           'carbohydrates_g' =>'required',
           'protrien_g' =>'required',
           'fiber_g' =>'required'

        ]);

         try {

         $InsertFood = CalorieCount::findorfail($id);;
         $InsertFood->name=$request->name;
         $InsertFood->av_potlon=$request->av_potlon;
         $InsertFood->calories=$request->calories;
         $InsertFood->fat_g=$request->fat_g;
         $InsertFood->saturated_fat_g=$request->saturated_fat_g;
         $InsertFood->carbohydrates_g=$request->carbohydrates_g;
         $InsertFood->protrien_g=$request->protrien_g;
         $InsertFood->fiber_g=$request->fiber_g;
         $InsertFood->country_code=$country_code;
         $InsertFood->active=$request->active;
         $InsertFood->save();


         return response()->json(['status' => 1,'data' => "Successfully Updated"], 200);

        }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

        }
       }


       public function adminsearchfood(Request $request){

        $this->validate($request, [
            'foodname' =>'required'
         ]);

      $search_food=$request->foodname;
      $food_name =CalorieCount::where('name', 'LIKE','%' . $search_food. '%')->get(['name','id']);

      $emptyArray = array();

      if ($food_name) {
          return response()->json(["food_name"=>$food_name]);
      } else if (!$food_name) {
          return response()->json($emptyArray);
      }

    }

    public function Usersearchfood(Request $request){

        $this->validate($request, [
            'foodname' =>'required'
         ]);

      $search_food=$request->foodname;
      $food_name =CalorieCount::where('name', 'LIKE','%' . $search_food. '%')->get(['name','id']);

      $emptyArray = array();

      if ($food_name) {
          return response()->json(["food_name"=>$food_name]);
      } else if (!$food_name) {
          return response()->json($emptyArray);
      }

    }

    public function fooddelete($id){


        try{
        $food = calorieCount::findorfail($id);
        $food->delete();
        return response()->json(['status' => 1,'data' => "Successfully Deleted"], 204);
        } catch (Exception $e) {return response()->json(['status' => 0,'data' => $e], 403);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalorieCount  $calorieCount
     * @return \Illuminate\Http\Response
     */
    public function TrainerViweClientCalorieCountCalculation(Request $request){

        $trainer_id = $request->roleid;

        $date = $request->date;
        $emptyArray = array();
        $TrainerViweClientCalorieCount = $emptyArray;

        try{

        if($date==null){
        $client_id = ClientTrainer::where('trainer_id',$trainer_id)->get('client_id');

          foreach ($client_id as $client_id) {
            $user_id=$client_id->client_id;

       $TrainerViweClientCalorieCount[] = TrainerViweAllUserCalorieCount::with(['getuserdate','getmacros'])
       ->where('user_id',$user_id)
       ->orderBy('id', 'DESC')
       ->first();

       }

       }else{

       $client_id = ClientTrainer::where('trainer_id',$trainer_id)->get('client_id');
       foreach ($client_id as $client_id) {
       $user_id=$client_id->client_id;

       $TrainerViweClientCalorieCount[] = TrainerViweAllUserCalorieCount::with(['getuserdate','getmacros'])
       ->where('user_id',$user_id)
       ->orderBy('id', 'DESC')
       ->first();

     }
     }

         $emptyArray = array();
         if ($TrainerViweClientCalorieCount) {
         return response()->json(["CalorieCount"=>$TrainerViweClientCalorieCount]);
         } else if (!$TrainerViweClientCalorieCount) {
         return response()->json($emptyArray);
         }

        }catch (Exception $e) {
            return response()->json(['status' => 0,'data' => $e ], 403);

            }
         }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalorieCount  $calorieCount
     * @return \Illuminate\Http\Response
     */
    public function SearchFood(Request $request){


        $this->validate($request, [
            'foodname' =>'required'
         ]);



    $userData = $request->get('userData');
    $user_id = $userData['user_id'];
    $country_code = $request->country_code;
    $search_food=$request->foodname;

    $food_name =CalorieCount::where('country_code',$country_code)->where('name', 'LIKE','%' . $search_food. '%')->get(['name','id']);

    $emptyArray = array();

    if ($food_name) {
        return response()->json(["food_name"=>$food_name]);
    } else if (!$food_name) {
        return response()->json($emptyArray);
    }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalorieCount  $calorieCount
     * @return \Illuminate\Http\Response
     */
    public function UserRequestFood(Request $request){

        $view_food=CalorieCount::where('active',0)->get();

        $emptyArray = array();

        if ($view_food) {
            return response()->json(["RequestFood"=>$view_food]);
        } else if (!$view_food) {
            return response()->json($emptyArray);
        }

      }

      public function AdminApproval(Request $request ,$id){


       try {

            $InsertFood = CalorieCount::findorfail($id);
            $InsertFood->name=$request->name;
            $InsertFood->av_potlon=$request->av_potlon;
            $InsertFood->calories=$request->calories;
            $InsertFood->fat_g=$request->fat_g;
            $InsertFood->saturated_fat_g=$request->saturated_fat_g;
            $InsertFood->carbohydrates_g=$request->carbohydrates_g;
            $InsertFood->protrien_g=$request->protrien_g;
            $InsertFood->fiber_g=$request->fiber_g;
           // $InsertFood->country_code=$country_code;
            $InsertFood->active=$request->active;
            $InsertFood->save();


            return response()->json(['status' => 1,'data' => "Successfully Updated"], 200);

          }catch (Exception $e) {
          return response()->json(['status' => 0,'data' => $e ], 403);

          }


      }

    }



