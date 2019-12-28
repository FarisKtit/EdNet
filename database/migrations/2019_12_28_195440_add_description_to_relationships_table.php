<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relationships', function (Blueprint $table) {
            $table->string('requester_description');
            $table->string('responder_description');
            $table->string('requester_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relationships', function (Blueprint $table) {
            $table->dropColumn('requester_description');
            $table->dropColumn('responder_description');
            $table->dropColumn('requester_question');
        });
    }
}
