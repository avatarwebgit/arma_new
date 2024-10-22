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
        Schema::table('sales_offer_form', function (Blueprint $table) {
            $table->addColumn('text', 'alpha')->nullable();
            $table->addColumn('text', 'formulla_more_details')->nullable();
            $table->addColumn('text', 'base_price_notes')->nullable();
            $table->addColumn('text', 'Operator')->nullable();
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
            $table->dropColumn('alpha');
            $table->dropColumn('formulla_more_details');
            $table->dropColumn('base_price_notes');
            $table->dropColumn('Operator');
        });
    }
};
