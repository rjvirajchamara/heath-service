<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use PHPUnit\Framework\Constraint\Exception;

class MusclesMassTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_create_MusclsMass()
    {
        $musclsmass=[
            'user_id'=>1,
        ];
        $response=$this->post("/api/musclemass", $musclsmass);
        $response->assertResponseStatus(201);
    }
}
