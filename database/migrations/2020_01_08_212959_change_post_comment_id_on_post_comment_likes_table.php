<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePostCommentIdOnPostCommentLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_comment_likes', function (Blueprint $table) {
            $table->dropForeign(['post_comment_id']);
            $table->foreign('post_comment_id')->references('id')->on('post_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comment_likes', function (Blueprint $table) {
            $table->dropForeign(['post_comment_id']);
        });
    }
}
