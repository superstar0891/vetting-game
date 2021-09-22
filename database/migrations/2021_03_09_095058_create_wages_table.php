<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('game_id');
            $table->integer('sport_id');
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->string('amount');
            $table->string('odd');
            $table->string('timezone');
            $table->string('game_name');
            $table->string('home_team_name');
            $table->integer('home_team_id');
            $table->string('away_team_name');
            $table->integer('away_team_id');
            $table->string('seasons');
            $table->integer('status');
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
        Schema::dropIfExists('wages');
    }
}
