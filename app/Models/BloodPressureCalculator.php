<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodPressureCalculator extends Model
{
    public $connection = "mysql";
    protected $table = 'blood_pressure_calculators';

    protected $fillable = [
        'user_id',
        'systopic_mm_Hg',
        'lastolio_mm_Hg',
        'blood_pressure_result',
        'date',

    ];

    public function getbloodpressure(){
       return $this->belongsTo(User::class,'id');
   }
}
