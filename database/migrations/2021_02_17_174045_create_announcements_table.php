<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization');
            $table->index('organization');
            $table->foreign('organization')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('attachment');
            $table->string('contact_person');
            $table->string('phone');
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
        Schema::dropIfExists('announcements', function (Blueprint $table) {
            $table->dropForeign('announcements_organization_foreign');
            $table->dropIndex('announcements_organization_index');
        });
    }
}
