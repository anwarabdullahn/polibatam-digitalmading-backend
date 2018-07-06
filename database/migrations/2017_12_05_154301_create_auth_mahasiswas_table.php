<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_mahasiswas', function (Blueprint $table) {
          $table->increments('id');
          $table->string('api_token');
          $table->integer('id_mahasiswa')->unsigned();
          $table->boolean('platfom')->default(0);
          $table->timestamps();

          $table->foreign('id_mahasiswa')->references('id')->on('mahasiswas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_mahasiswas');
    }
}
