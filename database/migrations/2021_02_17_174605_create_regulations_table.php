<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization');
            $table->index('organization');
            $table->foreign('organization')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('title');
            $table->string('regulatory_number');
            $table->text('description');
            $table->string('image');
            $table->string('attachment');
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
        Schema::dropIfExists('regulations', function (Blueprint $table) {
            $table->dropForeign('regulations_organization_foreign');
            $table->dropIndex('regulations_organization_index');
        });
    }
}
