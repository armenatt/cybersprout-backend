<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentChildCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('parent_child_comments')) {
            Schema::create('parent_child_comments', function (Blueprint $table) {
                $table->bigInteger('parent_comment_id')->unsigned();
                $table->bigInteger('child_comment_id')->unsigned();
            });
        }
        Schema::table('parent_child_comments', function (Blueprint $table) {
            $table->foreign('parent_comment_id')->references('id')->on('comments');
            $table->foreign('child_comment_id')->references('id')->on('comments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_child_comments');
    }
}
