<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineDoctorAppoinmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_doctor_appoinments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('doctors_id');
            $table->string('date');
            $table->string('time');
            $table->string('description');
            $table->integer('active');
            $table->text('link');
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
        Schema::dropIfExists('online_doctor_appoinments');
    }
}
