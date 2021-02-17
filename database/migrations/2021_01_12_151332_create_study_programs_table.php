<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major');
            $table->index('major');
            $table->foreign('major')->references('id')->on('majors')->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->text('description');
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
        Schema::dropIfExists('study_programs', function (Blueprint $table) {
            $table->dropForeign('study_programs_major_foreign');
            $table->dropIndex('study_programs_major_index');
        });
    }
}
