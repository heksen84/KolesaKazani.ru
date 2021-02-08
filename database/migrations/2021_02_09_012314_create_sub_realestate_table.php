<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubRealestateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_realestate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_type')->nullable();
            $table->unsignedInteger('floor')->nullable();
            $table->unsignedInteger('floors_house')->nullable();
            $table->unsignedInteger('rooms')->nullable();
            $table->unsignedInteger('area')->nullable();
            $table->unsignedInteger('ownership')->nullable();
            $table->unsignedInteger('kind_of_object')->nullable();
            $table->unsignedInteger('type_of_building')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_realestate');
    }
}
