<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonHealthDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_health_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_original_id');
            $table->decimal('weight');
            $table->string('weightunit');
            $table->string('heightunit');
            $table->decimal('height');
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
        Schema::dropIfExists('common_health_data');
    }
}
