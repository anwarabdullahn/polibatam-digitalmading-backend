<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePertanyaans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pertanyaan1')->nullable();
            $table->string('pertanyaan2')->nullable();
            $table->string('pertanyaan3')->nullable();
            $table->string('pertanyaan4')->nullable();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertanyaans');
    }
}
