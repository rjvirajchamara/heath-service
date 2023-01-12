<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    public function getdoctor()
{
    return $this->belongsTo(Doctor::class,'doctor_id','id');
}
public function getuser()
{
    return $this->belongsTo(User::class,'user_id','id');

}
    public function prescription_details(){
    return $this->hasMany(PrescriptionDetail::class,'doctor_appoinment_id','doctor_appoinment_id');
    }
}
