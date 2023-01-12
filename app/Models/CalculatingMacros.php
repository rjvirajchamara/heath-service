<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatingMacros extends Model{
    public $connection = "mysql";
    protected $table = 'calculating_macros';

   public function getmacros(){

    return $this->belongsTo(User::class, 'id');
    }
}
