<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortlinks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->index('user');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('long_url');
            $table->string('short_url');
            $table->unsignedInteger('visitor');
            $table->boolean('is_active');
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
        Schema::dropIfExists('shortlinks', function (Blueprint $table) {
            $table->dropForeign('shortlinks_user_foreign');
            $table->dropIndex('shortlinks_user_index');
        });
    }
}
