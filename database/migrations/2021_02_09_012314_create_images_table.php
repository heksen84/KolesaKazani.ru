<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advert_id')->nullable();
            $table->string('name', 36);
            $table->string('originalName', 60)->nullable()->index('originalName');
            $table->tinyInteger('storage_id');
            $table->string('uid', 10)->index('uid');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->index(['name', 'storage_id'], 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
