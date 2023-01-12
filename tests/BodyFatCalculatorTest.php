<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BodyFatCalculatorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_bodyfatcalculator()
    {
        $bodyfatcalculator=[
            "user_id"=>1,
            "frontupperarm"=>5,
            "backofupperarm"=>5.5,
            "sideofthewaist"=>7,
            "backbelowshoulderblade"=>8,

        ];
        $response=$this->post("/api/bodyfatcalculator", $bodyfatcalculator);
        $response->assertResponseStatus(201);
    }
}
