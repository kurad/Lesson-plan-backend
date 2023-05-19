<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_part_id')->unsigned();
            $table->text('teacher_activities');
            $table->text('learner_activities');
            $table->text('competences');
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
        Schema::dropIfExists('activities');
    }
};
