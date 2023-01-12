<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalorieCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        //food chart
        Schema::create('calorie_counts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('av_potlon');
            $table->decimal('calories');
            $table->decimal('fat_g');
            $table->decimal('saturated_fat_g');
            $table->decimal('carbohydrates_g');
            $table->decimal('protrien_g');
            $table->decimal('fiber_g');
            $table->integer('active');
            $table->integer('country_code');
            $table->integer('food_category_id');
            $table->integer('insert_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calorie_counts');
    }
}
