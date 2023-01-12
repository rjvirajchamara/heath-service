<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class MacrosCalculatorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_Macroscal()
    {
        $macroscal=[
            "user_id"=>1,
            "x"=>"Weightgain",
            "y"=>"HighactiveinlifestyleGymprogram",
            "z"=>"Proteinbooster"
        ];
        $response=$this->post("/api/macroscalculator", $macroscal);
        $response->assertResponseStatus(201);
    }
}
