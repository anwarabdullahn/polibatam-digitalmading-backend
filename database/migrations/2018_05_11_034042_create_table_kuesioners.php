<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKuesioners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuesioners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mahasiswa')->unsigned();
            $table->string('jawaban1')->nullable();
            $table->string('jawaban2')->nullable();
            $table->string('jawaban3')->nullable();
            $table->string('jawaban4')->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswas')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuesioners');
    }
}
