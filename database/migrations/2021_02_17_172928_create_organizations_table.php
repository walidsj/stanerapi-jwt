<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_category');
            $table->index('organization_category');
            $table->foreign('organization_category')->references('id')->on('organization_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->string('chairman');
            $table->string('contact');
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
        Schema::dropIfExists('organizations', function (Blueprint $table) {
            $table->dropForeign('organizations_organization_category_foreign');
            $table->dropIndex('organizations_organization_category_index');
        });
    }
}
