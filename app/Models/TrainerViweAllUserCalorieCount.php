<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerViweAllUserCalorieCount extends Model{

    public $connection = "mysql";

    public function getuserdate(){
    return $this->belongsTo(Client::class,'user_id','user_id');
    }
    public function getmacros(){
        return $this->hasMany(CalculatingMacros::class, 'user_id', 'user_id')->orderBy('id', 'DESC')->limit(1);
    }
    public function getUserCalorieCount()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
