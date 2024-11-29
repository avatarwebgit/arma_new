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
        Schema::create('contact_addresses', function (Blueprint $table) {
            $table->id();
            $table->text('title_modal')->nullable();
            $table->text('address_modal')->nullable();
            $table->text('tel_1_modal')->nullable();
            $table->text('tel_2_modal')->nullable();
            $table->text('tel_3_modal')->nullable();
            $table->text('email_modal')->nullable();
            $table->text('email_2_modal')->nullable();
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
        Schema::dropIfExists('contact_addresses');
    }
};
