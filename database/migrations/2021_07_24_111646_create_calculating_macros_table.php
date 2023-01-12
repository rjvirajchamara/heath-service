<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculatingMacrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculating_macros', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('carbs');
            $table->decimal('calorie');
            $table->decimal('proteins');
            $table->decimal('fats');
            $table->string('date');
            $table->string('macro_plan_name');
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
        Schema::dropIfExists('calculating_macros');
    }
}
