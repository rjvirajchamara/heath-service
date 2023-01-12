<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BmiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_bmi()
    {
        $bmi=[
        "user_id"=>1,
        "weight[unit]"=>'LB',
        "weight[value]"=>100,
        "height[value]"=>158,
        "height[unit]"=>'CM',
        ];
        $response=$this->post("/api/bmicalculator", $bmi);

        $response->assertResponseStatus(201);
    }
}
