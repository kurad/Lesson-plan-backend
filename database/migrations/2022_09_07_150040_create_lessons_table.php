<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('restrict')->onUpdate('cascade');
            $table->string('topic_area');
            $table->integer('duration');
            $table->date('date');
            $table->text('instructional_objective');
            $table->text('knowledge_and_understanding');
            $table->text('skills');
            $table->text('attitudes_and_values');
            $table->text('teaching_materials');
            $table->text('description_of_teaching');
            $table->text('reference');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('lessons');
    }
}
