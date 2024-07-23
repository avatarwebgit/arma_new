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
        Schema::create('market_permission', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('market_id')->unsigned();
            $table->foreign('market_id')->references('id')->on('markets');

            $table->text('role_ids')->nullable();
            $table->text('user_ids')->nullable();

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
        Schema::dropIfExists('market_permission');
    }
};
