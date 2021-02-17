<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester');
            $table->index('semester');
            $table->foreign('semester')->references('id')->on('semesters')->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->string('session');
            $table->unsignedInteger('sks')->length(1);
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
        Schema::dropIfExists('subjects', function (Blueprint $table) {
            $table->dropForeign('subjects_semester_foreign');
            $table->dropIndex('subjects_semester_index');
        });
    }
}
