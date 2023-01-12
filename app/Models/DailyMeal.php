<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyMeal extends Model{
    protected $table = 'daily_meals';




    public function fooddata(){

        return $this->morphToMany(CalorieCount::class,'calorie_counts')->first();
        }


}
