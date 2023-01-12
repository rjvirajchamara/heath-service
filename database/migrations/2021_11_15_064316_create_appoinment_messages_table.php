<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppoinmentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoinment_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_appointment_chats_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('massage');
            $table->string('date');
            $table->string('time');
            $table->string('name');
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
        Schema::dropIfExists('appoinment_messages');
    }
}
