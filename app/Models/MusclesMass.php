<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusclesMass extends Model
{
    public $connection = "mysql";
    public function getmusclesmass()
    {
        return $this->belongsTo(CommonHealthData::class, 'id');
    }
}
