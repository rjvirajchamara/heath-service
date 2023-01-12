<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
    ];

    public $connection = "mysql2";
    protected $table = 'users';


    public function getBmiCalculator()
    {
        return $this->hasMany(BmiCalculator::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getPiPonderal()
    {
        return $this->hasMany(PlPonderal::class,'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getBloodPressure()
    {
        return $this->hasMany(BloodPressureCalculator::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getBodyfatCalculator()
    {
        return $this->hasMany(BodyFatCalculator::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getBodyPartsMeasurementInputer()
    {
        return $this->hasMany(BodyPartsMeasurementInputer::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getFBSFastingBloodSugar()
    {
        return $this->hasMany(FBSFastingBloodSugar::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getMusclesMass()
    {
        return $this->hasMany(MusclesMass::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getCalorieCount(){
        return $this->hasMany(TrainerViweAllUserCalorieCount::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }

    public function getMacros(){
        
        return $this->hasMany(CalculatingMacros::class, 'user_id', 'id')->orderBy('id', 'DESC')->limit(1);
    }


}
