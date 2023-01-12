<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BodyPartsMeasurementInputerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_bodypartsmeasurementinputer()
    {
        $bodypartsmeasurementinputer=[
            "user_id"=>1,
            "crown"=>30,
            "shoulder"=>40,
            "chest"=>50,
            "waist"=>60,
            "hips"=>40,
            "inseam"=>50,
            "floor"=>60,
            "stomach"=>30,
            "thighs"=>60,
            "calves"=>80,
            "mmcrown"=>9,
            "mmshoulder"=>4,
            "mmchest"=>5,
            "mmwaist"=>6,
            "mmhips"=>4,
            "mminseam"=>5,
            "mmfloor"=>6,
            "mmstomach"=>3,
            "mmthighs"=>6,
            "mmcalves"=>8

        ];
        $response=$this->post("/api/bodypartsmeasurementinputer", $bodypartsmeasurementinputer);
        $response->assertResponseStatus(201);
    }
}
