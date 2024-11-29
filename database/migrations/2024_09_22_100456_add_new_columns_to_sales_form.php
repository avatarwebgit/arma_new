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
        Schema::table('sales_offer_form', function (Blueprint $table) {
            $table->addColumn('text','payment_options')->nullable();
            $table->addColumn('text','payment_count')->nullable();
            $table->addColumn('text','lc_term_and_conditions')->nullable();
            $table->addColumn('text','oa_term_and_conditions')->nullable();
            $table->addColumn('text','other_payment_term_and_conditions')->nullable();
            $table->addColumn('text','tt_term_and_conditions')->nullable();
            $table->addColumn('text','paypal_term_and_conditions')->nullable();
            $table->addColumn('text','dp_term_and_conditions')->nullable();
            $table->addColumn('text','western_union_term_and_conditions')->nullable();
            $table->addColumn('text','da_term_and_conditions')->nullable();
            $table->addColumn('text','moneygram_term_and_conditions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_offer_form', function (Blueprint $table) {
            $table->dropColumn('payment_options');
            $table->dropColumn('payment_count');
            $table->dropColumn('lc_term_and_conditions');
            $table->dropColumn('oa_term_and_conditions');
            $table->dropColumn('other_payment_term_and_conditions');
            $table->dropColumn('tt_term_and_conditions');
            $table->dropColumn('paypal_term_and_conditions');
            $table->dropColumn('dp_term_and_conditions');
            $table->dropColumn('western_union_term_and_conditions');
            $table->dropColumn('da_term_and_conditions');
            $table->dropColumn('moneygram_term_and_conditions');
        });
    }
};
