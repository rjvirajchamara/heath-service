<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    public $connection = "mysql2";
    protected $table = 'doctors';

    public function getdoctordata()
    {
        return $this->belongsTo(Doctor::class,'doctor_id','id');

    }

    public function appointments()
    {
        return $this->hasMany(DoctorAppoinment::class,'id','doctor_id');
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class,'category_id','id');
    }

  

}
