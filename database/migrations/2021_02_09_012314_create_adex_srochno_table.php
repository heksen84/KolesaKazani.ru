<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdexSrochnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adex_srochno', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('advert_id');
            $table->date('startDate');
            $table->date('finishDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adex_srochno');
    }
}
