<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester');
            $table->index('semester');
            $table->foreign('semester')->references('id')->on('semesters')->onDelete('cascade');
            $table->string('name');
            $table->string('npm');
            $table->string('gender');
            $table->unsignedInteger('year_generation')->length(4);
            $table->unsignedInteger('year_graduation')->length(4);
            $table->string('class');
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
        Schema::dropIfExists('students', function (Blueprint $table) {
            $table->dropForeign('students_semester_foreign');
            $table->dropIndex('students_semester_index');
        });
    }
}
