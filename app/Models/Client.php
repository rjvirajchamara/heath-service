<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $connection = "mysql2";

    public function getuserdate(){

        return $this->hasOne(Client::class, 'user_id', 'user_id')->get(['full_name','id']);
    }
}
