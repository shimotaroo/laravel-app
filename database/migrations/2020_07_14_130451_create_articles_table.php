<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('prefecture_id')->unsigned();
            $table->foreign('prefecture_id')->references('id')->on('prefectures');
            $table->bigInteger('company_type_id')->unsigned();
            $table->foreign('company_type_id')->references('id')->on('company_types');
            $table->bigInteger('phase_id')->unsigned();
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->text('question_content');
            $table->text('other_information');
            $table->text('impression');
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
        Schema::dropIfExists('articles');
    }
}
