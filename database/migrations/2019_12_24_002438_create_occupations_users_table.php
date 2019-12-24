<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupationsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupations_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('occupation_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('occupation_id')->references('id')->on('occupations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupations_users');
    }
}