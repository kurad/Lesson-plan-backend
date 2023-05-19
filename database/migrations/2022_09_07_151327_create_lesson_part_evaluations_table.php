<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonPartEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_part_evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->integer('lesson_part_id')->unsigned();
            $table->foreign('lesson_part_id')->references('id')->on('lesson_parts')->onDelete('restrict')->onUpdate('cascade');
            $table->softDeletesTz();
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
        Schema::dropIfExists('lesson_part_evaluations');
    }
}