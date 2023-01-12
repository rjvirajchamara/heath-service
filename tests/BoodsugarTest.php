<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BoodsugarTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_boodsugar()
    {
        $boodsugar=[
            "user_id"=>1,
            "boodsugarcount"=>200,
            "unit"=>'AfterEating',


        ];
        $response=$this->post("/api/boodsugartest", $boodsugar);
        $response->assertResponseStatus(201);
    }
}
