<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_modification', function (Blueprint $table) {
            $table->integer('id_car_modification', true)->comment('ID');
            $table->integer('id_car_serie')->index('id_car_serie');
            $table->integer('id_car_model')->index('id_car_model');
            $table->string('name', 255);
            $table->integer('start_production_year')->nullable();
            $table->integer('end_production_year')->nullable();
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
        Schema::dropIfExists('car_modification');
    }
}
