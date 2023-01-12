<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyFatCalculator extends Model
{
    protected $table ='body_fat_calculators';
    public $connection = "mysql";
    protected $fillable =[
        'user_id',
        'front_upper_arm',
        'back_of_upper_arm',
        'side_of_the_waist',
        'back_below_shoulder_blade',
        'body_fat',
        'body_fat_result',
        'date',
       ];

    public function getbodfatcalculator()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
