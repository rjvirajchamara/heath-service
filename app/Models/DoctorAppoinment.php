<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAppoinment extends Model
{
    public $connection = "mysql";

    public function getDoctorDetails()
    {
        return $this->belongsTo(Doctor::class,'doctors_id','id');
    }
    public function getuser(){
        return $this->belongsTo(User::class,'user_id','id');
    }



}
