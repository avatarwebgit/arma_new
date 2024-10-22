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
        Schema::table('header1', function (Blueprint $table) {
            $table->addColumn('integer','cat_id')->default(1);
            $table->addColumn('text','currency')->nullable();
            $table->addColumn('text','title_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('header1', function (Blueprint $table) {
            $table->dropColumn('cat_id');
            $table->dropColumn('currency');
            $table->dropColumn('title_2');
        });
    }
};
