<?php

use App\Models\BloodPressureCalculator;
use App\Http\Controllers\BloodPressureCalculatorController;
use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//'middleware' => 'isUser'
   $router->group(['prefix' => 'api'], function () use ($router) {

   $router->post('/user-check','CalculatorController@userCheck');

   $router->group(['middleware' => 'Istrainer'], function () use ($router) {
   $router->get('/allcalculatordata','CalculatorController@All_Calculator_data');
   $router->post('/bodyfatcalculator', 'BodyFatCalculatorController@BodyFatCalculator');
   $router->post('/bmicalculator','CalculatorController@BmiCalculator');
   $router->post('/caloriecalculator','CalorieCalculatorController@CalorieCalculator');
   $router->post('/bloodpressureCalculator','BloodPressureCalculatorController@BloodPressureCheck');
   $router->post('/caloriedbmealfoodcount', 'CalculatorController@CalorieDBMealfoodcount');
   $router->post('/bonedensity', 'BoneDensityController@BoneDensity');
   $router->post('/fastingbloodsugar', 'FBSFastingBloodSugarController@FBSFastingBloodSugar');
   $router->post('/bonedensity', 'CalculatorController@BoneDensity');
   $router->post('/bodypartsmeasurementinputer', 'BodyPartsMeasurementInputerController@BodyPartsMeasurement');
   $router->post('/plponderals', 'PlPonderalController@ponderal_index');
   $router->post('/musclemass', 'MusclesMassController@Muscle_Mass');
   $router->post('/boodsugartest', 'FBSFastingBloodSugarController@boodsugartest');
   $router->post('/macroscalculator', 'CalculatingMacrosController@MacrosCalculator');
   $router->get('/viewallhealthdata', 'AllHealthDataController@ViewAllHealthData');
//  $router->post('/user-check', 'CalculatorController@userCheck');
   $router->post('/commonhealthdata', 'CommonHealthDataController@StoreUserCommonHealthData');




   $router->get('/trainerviweuserhealthdata','CommonHealthDataController@trainerViewCommonHealthData');


   $router->get('/viewbloodpressure', 'BloodPressureCalculatorController@ViewBloodPressure');
   $router->get('/viewbmi', 'BmiCalculatorController@ViewBmi');
   $router->get('/viewbodyfat', 'BodyFatCalculatorController@ViewBodyFat');
   $router->get('/viewbodypartsmeasurement', 'BodyPartsMeasurementInputerController@ViewBodyPartsMeasurement');
   $router->get('/viewmacros', 'CalculatingMacrosController@ViewMacros');
   $router->get('/viewbloodsugar', 'FBSFastingBloodSugarController@ViewBloodSugar');
   $router->get('/viewmusclesmass', 'MusclesMassController@ViewMusclesMass');
   $router->get('/viewplponderal', 'PlPonderalController@viewplponderal');
   $router->post('/searchfood', 'CalorieCountController@searchFood');

   $router->post('/trainerselectuserdoctorappoinment','DoctorAppoinmentController@doctorappoinment');
   $router->post('/trainerdoctorappoinment','DoctorAppoinmentController@doctorappoinment');
   $router->post('/doctorappoinment','DoctorAppoinmentController@doctorappoinment');

   $router->post('/searchclients','TrainerDoctorAppointmentController@SearchClients');
   $router->post('/onlinedoctorappoinment','OnlineDoctorAppoinmentController@OnlineDoctorAppoinment');

   $router->get('/trainerviweclientcaloriecount','CalorieCountController@TrainerViweClientCalorieCountCalculation');
   $router->get('/alluserhealthdata', 'CommonHealthDataController@viewCommonHealthData');
   });

   $router->group(['middleware' => 'isUser'], function () use ($router) {


   $router->get('/viewbloodpressure', 'BloodPressureCalculatorController@ViewBloodPressure');
   $router->get('/viewplponderals', 'PlPonderalController@Viewplponderal');
   $router->get('/viewbmi', 'BmiCalculatorController@ViewBmi');
   $router->get('/viewbodyfat', 'BodyFatCalculatorController@ViewBodyFat');
   $router->get('/viewbodypartsmeasurement', 'BodyPartsMeasurementInputerController@ViewBodyPartsMeasurement');
   $router->get('/viewmacros', 'CalculatingMacrosController@ViewMacros');
   $router->get('/viewbloodsugar', 'FBSFastingBloodSugarController@ViewBloodSugar');
   $router->get('/viewmusclesmass', 'MusclesMassController@ViewMusclesMass');
   $router->get('/viewplponderal', 'PlPonderalController@viewplponderal');
   $router->post('/searchfood', 'CalorieCountController@searchFood');


   $router->post('/appoinmentmessage','DoctorAppointmentChatController@AppoinmentMessage');
   $router->delete('/deletechat/{id}', 'DoctorAppointmentChatController@DeleteChat');
   $router->get('/showchatlist','DoctorAppointmentChatController@Showchatlist');
   $router->get('/showcmessage','DoctorAppointmentChatController@ShowcMessage');
   $router->get('/trainersearchuserhelthdata','CommonHealthDataController@TrainerSearchUserHelthData');
   $router->get('/alldoctor','DoctorController@AllDoctor');
   $router->get('/adminviwefood','FoodChartController@ShowFood');
   $router->get('/clientviwefood','FoodChartController@ClientViweFood');
   $router->post('/createdailymeal', 'CalorieCountController@create_daily_meal');
   $router->get('/clorieCountCalculation', 'CalorieCountController@ClientViewCalorieCount');
   $router->get('/viewdailymeals','UserDailyMealsController@ViewDailyMeals');
   $router->get('/myfood','CalorieCountController@Myfood');
   $router->get('/suggestionfood','CalorieCountController@suggestionfood');
   $router->get('/viewuserhealthdata', 'CommonHealthDataController@viewUserCommonHealthData');
   });


    $router->group(['middleware' => 'Isdoctor'], function () use ($router) {

    $router->put('/doctoronline/{id}','DoctorController@DoctorOnline');
    $router->get('/scheduledates','DoctorAppoinmentController@scheduleDates');
    $router->post('/ViewScheduleAndPending','DoctorAppoinmentController@ViewScheduleAndPending');
    $router->get('/upcominappoinment','DoctorAppoinmentController@upcominAppoinment');
    $router->get('/scheduleappoinment','DoctorAppoinmentController@ScheduleAppoinment');
    $router->get('/doctorviweuserHealthdata','DoctorAppoinmentController@DoctorViweUserAllHealthData');
    $router->post('/createprescription','PrescriptionController@CreatePrescription');
    $router->put('/doctorappointmentamount/{id}','DoctorController@DoctorAppointmentAmount');
    $router->post('/createdoctoravailabledate','DoctorAvailableDateController@CreateDoctorAvailableDate');
    $router->put('/updatedoctoravailabledate','DoctorAvailableDateController@UpdateDoctorAvailableDate');
    $router->get('/viewdoctoravailabledate','DoctorAvailableDateController@ViewDoctorAvailableDate');
    $router->delete('/deletedoctoravailabledate/{id}','DoctorAvailableDateController@DeleteDoctorAvailableDate');
    $router->put('/doctorrescheduleappoinment/{id}','DoctorAppoinmentController@RescheduleAppoinment');
    $router->put('/doctorcencelappoinment/{id}','DoctorAppoinmentController@CencelAppoinment');
    $router->put('/doctoracceptappoinment/{id}','DoctorAppoinmentController@DoctorAcceptAppoinment');
    $router->get('/viewOnlineDoctorAppoinment','OnlineDoctorAppoinmentController@viewOnlineDoctorAppoinment');
    $router->put('/onlinedoctorappoinmenstatus/{id}','OnlineDoctorAppoinmentController@OnlineDoctorAppoinmenStatus');
    $router->get('/viewpendingappoinment','DoctorAppoinmentController@ViewpendingAppoinment');
    $router->get('/viweCreatePrescription','PrescriptionController@viweCreatePrescription');


    $router->put('/doctorcompleteappoinment/{id}','DoctorAppoinmentController@DoctorcompleteAppoinment');



    $router->get('/viwedoctorprescription','PrescriptionController@ViweDoctorPrescription');
    $router->get('/viwesummarydoctorprescription','PrescriptionController@ViweSummaryDoctorPrescription');








    });

    $router->group(['middleware' => 'SuperAdmin'], function () use ($router) {

    //$router->get('/viewuserhealthdata', 'CommonHealthDataController@viewUserCommonHealthData');
    $router->put('/updatefood/{id}', 'CalorieCountController@foodupdate');
    $router->get('/adminsearchfood', 'CalorieCountController@adminsearchfood');
    $router->delete('/deletefood/{id}', 'CalorieCountController@fooddelete');
    $router->get('/userrequestfood','CalorieCountController@userrequestfood');
    $router->put('/adminApproval/{id}','CalorieCountController@AdminApproval');
    });

     $router->group(['middleware' => 'Isuserandtrainer'], function () use ($router) {
     $router->get('/viweuserprescription','PrescriptionController@viweUserPrescription');
     $router->get('/viweonlinedoctor','DoctorController@ViweOnlineDoctor');
     $router->get('/searchOnlinedoctor','DoctorController@searchOnlinedoctor');
     $router->get('/userupcominappoinment', 'DoctorAppoinmentController@UserUpcominAppoinment');

     });

     $router->group(['middleware' => 'Isadminanduser'], function () use ($router) {
        $router->post('/Insertfood', 'CalorieCountController@InsertFood');
     });
   });

