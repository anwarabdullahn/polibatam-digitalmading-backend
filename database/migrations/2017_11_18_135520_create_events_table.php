<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->date('date');
          $table->longText('description');
          $table->string('image')->default('feedimages.png');
          $table->integer('id_user')->unsigned();
          $table->boolean('status')->default(0);
          $table->timestamps();

          $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
