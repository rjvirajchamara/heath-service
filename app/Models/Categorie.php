<?php

namespace App\Models;

use App\Models\Categorie as ModelsCategorie;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model{

    public $connection = "mysql2";
    protected $table = 'categories';

    public function getCategorie()
    {
        return $this->hasOne(categorie::class,'id','category_id');
    }
}

