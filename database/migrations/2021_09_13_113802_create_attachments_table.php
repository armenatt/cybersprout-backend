<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_reference');
            $table->timestamps();
        });
        DB::table('attachments')->insert(['attachment_reference' => '[reference to default user avatar]']);
        DB::table('attachments')->insert(['attachment_reference' => '[reference to default admin avatar]']);
        DB::table('attachments')->insert(['attachment_reference' => '[reference to default moderator avatar]']);
        DB::table('attachments')->insert(['attachment_reference' => '[reference to default creator avatar]']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
