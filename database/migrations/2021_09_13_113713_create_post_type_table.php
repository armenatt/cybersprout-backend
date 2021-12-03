<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_type', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->tinyText('description');
        });
        DB::table('post_type')->insert(['type' => 'QuickNews']);
        DB::table('post_type')->insert(['type' => 'Article']);
        DB::table('post_type')->insert(['type' => 'Match']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_type');
    }
}
