<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarSerieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_serie', function (Blueprint $table) {
            $table->integer('id_car_serie', true)->comment('ID');
            $table->integer('id_car_model')->index('id_car_model');
            $table->integer('id_car_generation')->nullable();
            $table->string('name', 255)->index('name');
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
        Schema::dropIfExists('car_serie');
    }
}
