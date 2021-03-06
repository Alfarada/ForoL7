<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('title');
            $table->string('slug');
            $table->mediumText('content');

            $table->boolean('pending')->default(true);
            $table->unsignedInteger('answer_id')->nullable();

            $table->integer('score')->default(0);

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
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('post');
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
