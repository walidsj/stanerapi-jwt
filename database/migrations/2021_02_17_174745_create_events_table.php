<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization');
            $table->index('organization');
            $table->foreign('organization')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('committee');
            $table->string('image');
            $table->string('attachment');
            $table->string('contact_person');
            $table->string('phone');
            $table->boolean('is_featured');
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
        Schema::dropIfExists('events', function (Blueprint $table) {
            $table->dropForeign('events_organization_foreign');
            $table->dropIndex('events_organization_index');
        });
    }
}
