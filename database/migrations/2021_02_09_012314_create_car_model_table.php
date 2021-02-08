<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_model', function (Blueprint $table) {
            $table->integer('id_car_model', true)->comment('ID');
            $table->integer('id_car_mark')->index('id_car_mark');
            $table->string('name', 255)->index('name');
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
        Schema::dropIfExists('car_model');
    }
}
