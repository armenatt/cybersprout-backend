<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('author_id')->unsigned();
                $table->integer('like_count');
                $table->integer('dislike_count');
                $table->text('text');
                $table->bigInteger('attachment')->unsigned()->nullable();
                $table->bigInteger('post_id')->unsigned();
                $table->tinyInteger('is_updated');
                $table->tinyInteger('is_hidden');
                $table->timestamps();

            });
        }
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('attachment')->references('id')->on('attachments');
            $table->foreign('post_id')->references('id')->on('posts');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
