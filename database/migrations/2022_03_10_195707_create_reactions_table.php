<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('reaction');

            $table->unsignedBigInteger('reactionable_id');
            $table->string('reactionable_type');

            $table->primary(['user_id', 'reactionable_id', 'reaction', 'reactionable_type'],
                'reactions_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reactions');
    }
}
