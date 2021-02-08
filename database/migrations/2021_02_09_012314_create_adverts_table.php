<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->index('title');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('subcategory_id')->nullable();
            $table->unsignedInteger('inner_id')->nullable();
            $table->string('text', 1024)->nullable()->index('text');
            $table->string('phone', 14)->nullable()->default('NULL');
            $table->unsignedInteger('price')->nullable()->index('price');
            $table->float('coord_lat', 10, 0);
            $table->float('coord_lon', 10, 0);
            $table->unsignedInteger('region_id')->index('region_id');
            $table->unsignedInteger('city_id')->index('city_id');
            $table->string('lang', 2);
            $table->tinyInteger('public');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->timestamp('startDate')->useCurrent();
            $table->timestamp('finishDate')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
