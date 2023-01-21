<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_jenis_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_data_utama_id');
            $table->string('nama_jenis_data')->nullable();
            $table->foreign('web_data_utama_id')->references('id')->on('web_data_utama')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_jenis_data');
    }
}
