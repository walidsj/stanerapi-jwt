<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_program');
            $table->index('study_program');
            $table->foreign('study_program')->references('id')->on('study_programs')->onDelete('cascade');
            $table->string('name');
            $table->string('number');
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
        Schema::dropIfExists('semesters', function (Blueprint $table) {
            $table->dropForeign('semesters_study_program_foreign');
            $table->dropIndex('semesters_study_program_index');
        });
    }
}
