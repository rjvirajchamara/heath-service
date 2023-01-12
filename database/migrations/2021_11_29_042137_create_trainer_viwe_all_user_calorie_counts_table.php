<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainerViweAllUserCalorieCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_viwe_all_user_calorie_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('fat_g');
            $table->decimal('carbohydrates_g');
            $table->decimal('protrien_g');
            $table->decimal('calorie');
            $table->decimal('percentage_fat_g');
            $table->decimal('percentage_carbohydrates_g');
            $table->decimal('percentage_protrien_g');
            $table->decimal('percentage_calorie_g');
            $table->decimal('target_protrien_g');
            $table->decimal('target_fat_g');
            $table->decimal('target_carbohydrates_g');
            $table->decimal('target_percentage_calorie_g');
            $table->string('date');
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
        Schema::dropIfExists('trainer_viwe_all_user_calorie_counts');
    }
}
