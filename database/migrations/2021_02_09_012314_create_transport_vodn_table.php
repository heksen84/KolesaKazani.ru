<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportVodnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_vodn', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type');
            $table->unsignedInteger('mark')->nullable();
            $table->unsignedInteger('model')->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->unsignedInteger('steering_position')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->unsignedInteger('engine_type')->nullable();
            $table->unsignedInteger('customs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_vodn');
    }
}
