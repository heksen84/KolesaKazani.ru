<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKzCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kz_city', function (Blueprint $table) {
            $table->increments('city_id');
            $table->unsignedInteger('region_id')->default(0)->index('region_id');
            $table->string('name', 128)->default('')->index('name');
            $table->string('url', 40)->index('url');
            $table->string('coords', 22);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kz_city');
    }
}
