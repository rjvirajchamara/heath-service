<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTrainer extends Model
{

    public $connection = "mysql2";
    protected $table = 'client_trainer';




    public function getuserdate()
    {
        return $this->belongsTo(Client::class, 'id', 'user_id')->get();
    }

}

