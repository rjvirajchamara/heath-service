<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BloodPressureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_BloodPressure()
    {
        $bloodPressure=[
            "Systopic_mm_Hg"=>11,
            "lastolio_mm_Hg"=>90
        ];
        $response=$this->post("/api/bloodpressureCalculator", $bloodPressure);
        $response->assertResponseStatus(201);
    }
}
