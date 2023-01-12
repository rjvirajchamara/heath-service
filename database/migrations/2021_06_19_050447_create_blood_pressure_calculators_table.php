<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodPressureCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_pressure_calculators', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('systopic_mm_Hg');
            $table->decimal('lastolio_mm_Hg');
            $table->string('blood_pressure_result');
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
        Schema::dropIfExists('blood_pressure_calculators');
    }
}
