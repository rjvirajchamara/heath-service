<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('food_categories')->insert([[

            'food_category_name' =>'Fruit and juices'
        ],[
            'food_category_name' =>'Snacks'
        ],[
            'food_category_name' =>'Fats and oil'
        ],[
            'food_category_name' =>'Meat product'
        ],[
            'food_category_name' =>'Soup,Souses'
        ]
    ]);
    }
}
