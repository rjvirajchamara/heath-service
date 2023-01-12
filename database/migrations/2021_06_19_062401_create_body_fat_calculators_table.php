<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyFatCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_fat_calculators', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->decimal('front_upper_arm');
            $table->decimal('back_of_upper_arm');
            $table->decimal('side_of_the_waist');
            $table->decimal('back_below_shoulder_blade');
            $table->decimal('body_fat');
            $table->string('body_fat_result');
            $table->string('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('body_fat_calculators');
    }
}
