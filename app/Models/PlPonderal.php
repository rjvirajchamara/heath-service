<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlPonderal extends Model
{
    protected $table = 'pl_ponderals';
    public $connection = "mysql";
    protected $fillable = [
        'user_id',
        'pl_value',
        'message',

    ];

    public function getplPonderal()
    {
        return $this->belongsTo(CommonHealthData::class, 'id');
    }
}
