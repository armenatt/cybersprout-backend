<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->string('username');
                $table->string('password');
                $table->text('about_me')->nullable();
                $table->integer('karma');
                $table->bigInteger('avatar')->unsigned()->nullable();
                $table->tinyInteger('is_banned');
                $table->bigInteger('role')->unsigned();
                $table->date('date_of_birth')->nullable();
                $table->timestamp('last_online');
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamps();


            });

        }
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role')->references('id')->on('roles');
            $table->foreign('avatar')->references('id')->on('attachments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
