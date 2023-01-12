<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BmiCalculator extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testExampled()
    {
        $response=$this->get("/");
        $response->assertResponseStatus(200);
    }
}
