<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('post_dislikes')) {
            Schema::create('post_dislikes', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('post_id')->unsigned();
                $table->bigInteger('user_id')->unsigned();
                $table->timestamps();


            });
        }
        Schema::table('post_dislikes', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('post_dislikes');
    }
}
