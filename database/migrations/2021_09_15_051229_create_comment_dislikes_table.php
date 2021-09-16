<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('comment_dislikes')) {
            Schema::create('comment_dislikes', function (Blueprint $table) {
                $table->bigInteger('comment_id')->unsigned();
                $table->bigInteger('user_id')->unsigned();
                $table->timestamps();


            });
        }
        Schema::table('comment_dislikes', function (Blueprint $table) {
            $table->foreign('comment_id')->references('id')->on('comments');
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
        Schema::dropIfExists('comment_dislikes');
    }
}
