<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('region_id')->index('region_id');
            $table->integer('place_id')->nullable()->index('place_id');
            $table->string('insta_login', 16);
            $table->string('insta_pass', 16);
            $table->string('vk_login', 16);
            $table->string('vk_pass', 16);
            $table->string('ok_login', 16);
            $table->string('ok_pass', 16);
            $table->string('hash_tag', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
}
