<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('announcements', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->longText('description')->nullable();
      $table->string('image');
      $table->integer('id_user')->unsigned();
      $table->integer('id_category')->unsigned()->nullable();
      $table->boolean('status')->default(0);
      $table->string('file')->nullable();
      $table->timestamps();

      $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
      $table->foreign('id_category')->references('id')->on('announcement_categories')->onUpdate('cascade');
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('announcements');
  }
}
