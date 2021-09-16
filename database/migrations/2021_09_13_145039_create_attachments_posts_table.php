<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attachments_posts')) {
            Schema::create('attachments_posts', function (Blueprint $table) {
                $table->bigInteger('post_id')->unsigned();
                $table->bigInteger('attachment_id')->unsigned();


            });
        }
        Schema::table('attachments_posts', function (Blueprint $table) {
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
        Schema::dropIfExists('attachments_posts');
    }
}
