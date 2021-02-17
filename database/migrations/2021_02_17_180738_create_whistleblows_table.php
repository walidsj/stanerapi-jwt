<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhistleblowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whistleblows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->index('user');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('organization');
            $table->index('organization');
            $table->foreign('organization')->references('id')->on('organizations')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('attachment');
            $table->boolean('is_secret');
            $table->boolean('is_anonim');
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
        Schema::dropIfExists('whistleblows', function (Blueprint $table) {
            $table->dropForeign('whistleblows_user_foreign');
            $table->dropIndex('whistleblows_user_index');
            $table->dropForeign('whistleblows_organization_foreign');
            $table->dropIndex('whistleblows_organization_index');
        });
    }
}
