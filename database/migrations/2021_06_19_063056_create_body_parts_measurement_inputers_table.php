<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyPartsMeasurementInputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_parts_measurement_inputers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('bust');
            $table->decimal('stomach');
            $table->decimal('chest');
            $table->decimal('calves');
            $table->decimal('hips');
            $table->decimal('weight');
            $table->decimal('arm');
            $table->decimal('height');
            $table->decimal('thighs');
            $table->string('unitbust');
            $table->string('unitstomach');
            $table->string('unitchest');
            $table->string('unitcalves');
            $table->string('unithips');
            $table->string('unitweight');
            $table->string('unitarm');
            $table->string('unitthighs');
            $table->string('unitheight');
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
        Schema::dropIfExists('body_parts_measurement_inputers');
    }
}
