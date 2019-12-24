<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationships_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requester_id')->unsigned()->index();
            $table->integer('responder_id')->unsigned()->index();
            $table->integer('relationship_id')->unsigned()->index();
            $table->boolean('accepted')->default(0)->index();
            $table->timestamps();
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('responder_id')->references('id')->on('users');
            $table->foreign('relationship_id')->references('id')->on('relationships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relationships_users');
    }
}
