<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FBSFastingBloodSugar extends Model
{
    public $connection = "mysql";
    public function getfbsfastingboodsugar()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
