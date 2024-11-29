<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_header2', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('header_category')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('header2_id');
            $table->foreign('header2_id')->references('id')->on('header2')->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['category_id','header2_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_header2');
    }
};
