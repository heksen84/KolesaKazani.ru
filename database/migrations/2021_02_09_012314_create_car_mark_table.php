<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarMarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_mark', function (Blueprint $table) {
            $table->integer('id_car_mark', true)->comment('ID');
            $table->string('name', 255);
            $table->string('name_rus', 255)->nullable();
            $table->unsignedInteger('date_create')->nullable();
            $table->unsignedInteger('date_update')->nullable();
            $table->integer('id_car_type')->index('id_car_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_mark');
    }
}
