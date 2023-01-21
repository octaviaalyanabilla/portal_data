<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 15)->unique();
            $table->string('email');
            $table->string('password');
            $table->string('gambar')->nullable();
            $table->enum('level', ['admin', 'user']);
            $table->rememberToken();
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
        Schema::dropIfExists('web_user');
    }
}
