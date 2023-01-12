<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodyFatManChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_fat_man_charts', function (Blueprint $table) {
            $table->id();
            $table->integer('MM');
            $table->decimal('AGE_16_29');
            $table->decimal('AGE_30_39');
            $table->decimal('AGE_40_49');
            $table->decimal('AGE_50');
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
        Schema::dropIfExists('body_fat_man_charts');
    }
}
