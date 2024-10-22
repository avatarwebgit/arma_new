<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bidhistories', function (Blueprint $table) {
            $table->string('quantity_win')->default(0);
            $table->integer('is_win')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bidhistories', function (Blueprint $table) {
            $table->dropColumn('quantity_win');
            $table->dropColumn('is_win');
        });
    }
};
