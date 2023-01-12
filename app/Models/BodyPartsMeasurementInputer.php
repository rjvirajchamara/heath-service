<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyPartsMeasurementInputer extends Model
{
    protected $table = 'body_parts_measurement_inputers';
    public $connection = "mysql";
    protected $fillable = [
        'user_id',
        'shoulder',
        'crown',
        'thighs',
        'chest',
        'waist',
        'hips',
        'inseam',
        'floor',
        'stomach',
        'calves',
        'date',

    ];

    public function getbodypartmeasurement()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
