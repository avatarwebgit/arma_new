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
        Schema::table('markets', function (Blueprint $table) {
            $table->addColumn('text', 'ready_to_open')->nullable();
            $table->addColumn('text', 'opening')->nullable();
            $table->addColumn('text', 'q_1')->nullable();
            $table->addColumn('text', 'q_2')->nullable();
            $table->addColumn('text', 'q_3')->nullable();
            $table->addColumn('text', 'alpha')->nullable();
            $table->addColumn('text', 'term_conditions')->nullable();
            $table->addColumn('text', 'show_alpha')->nullable();
            $table->dropColumn('description');
            $table->dropColumn('offer_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn('ready_to_open');
            $table->dropColumn('opening');
            $table->dropColumn('q_1');
            $table->dropColumn('q_2');
            $table->dropColumn('q_3');
            $table->dropColumn('alpha');
            $table->dropColumn('term_conditions');
            $table->dropColumn('show_alpha');
            $table->addColumn('text', 'description')->nullable();
            $table->addColumn('text', 'offer_price')->nullable();
        });
    }
};
