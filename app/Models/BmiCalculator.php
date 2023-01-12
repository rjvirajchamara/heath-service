<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class BmiCalculator extends Model{

    public $connection = "mysql";
    protected $table = 'bmi_calculators';

    protected $fillable = [
        'user_id',
        'bmi_value',
        'message',

    ];
    public function getbmi()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
