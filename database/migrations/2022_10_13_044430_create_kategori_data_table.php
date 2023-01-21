<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_kategori_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('web_jenis_data_id');
            $table->string('nama_kategori_data', 100)->nullable();
            $table->foreign('web_jenis_data_id')->references('id')->on('web_jenis_data')->onDelete('cascade');
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
        Schema::dropIfExists('web_kategori_data');
    }
}
