<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlponderalsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function test_can_create_Plponderals(){

    //  $user=[
    //    'weight[0][unit]' =>'Kg',
    //    'weight[0][value]' =>100,
    ////    'height[0][value]'=>1.58,
    //     'height[0][unit]'=>'M',
    //     'user_id'=>1

    // ];
    //  $response=$this->post("/api/plponderals",$user);
    //   $response->assertResponseStatus(201);

    // }
    public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(),
            $this->response->getContent()
        );
    }
}
