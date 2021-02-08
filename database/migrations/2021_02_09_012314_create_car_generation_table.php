<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarGenerationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_generation', function (Blueprint $table) {
            $table->integer('id_car_generation', true);
            $table->integer('id_car_model')->index('id_car_model');
            $table->string('name', 255);
            $table->string('year_begin', 255)->nullable();
            $table->string('year_end', 255)->nullable();
            $table->unsignedInteger('date_create');
            $table->unsignedInteger('date_update')->nullable();
            $table->integer('id_car_type')->default(0)->index('id_car_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_generation');
    }
}
