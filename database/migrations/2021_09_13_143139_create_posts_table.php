<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('author_id')->unsigned();
                $table->string('title');
                $table->string('source_link');
                $table->tinyInteger('is_updated');
                $table->integer('tags');
                $table->integer('view_count');
                $table->bigInteger('type')->unsigned();
                $table->bigInteger('game')->unsigned();
                $table->longText('content');
                $table->integer('like_count');
                $table->integer('dislike_count');
                $table->timestamps();
            });
        }
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('type')->references('id')->on('post_type');
            $table->foreign('game')->references('id')->on('games');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
