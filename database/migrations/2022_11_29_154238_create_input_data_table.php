<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_input_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_data_utama_id');
            $table->unsignedBigInteger('web_jenis_data_id');
            $table->unsignedBigInteger('web_kategori_data_id');
            $table->unsignedBigInteger('web_tahun_data_id');
            $table->string('jumlah_data')->nullable();
            $table->foreign('web_data_utama_id')->references('id')->on('web_data_utama')->onDelete('cascade');
            $table->foreign('web_jenis_data_id')->references('id')->on('web_jenis_data')->onDelete('cascade');
            $table->foreign('web_kategori_data_id')->references('id')->on('web_kategori_data')->onDelete('cascade');
            $table->foreign('web_tahun_data_id')->references('id')->on('web_tahun_data')->onDelete('cascade');
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
        Schema::dropIfExists('web_input_data');
    }
}
