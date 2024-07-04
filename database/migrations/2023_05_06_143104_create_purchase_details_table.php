<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('unitcost');
            $table->integer('total');
            $table->string('payment_method_id');
            $table->string('card_brand')->nullable();
            $table->string('card_last4')->nullable();
            $table->integer('card_exp_month')->nullable();
            $table->integer('card_exp_year')->nullable();
            $table->string('card_fingerprint')->nullable();
            $table->string('card_country')->nullable();
            $table->boolean('card_checks_address_line1_check')->nullable();
            $table->boolean('card_checks_address_postal_code_check')->nullable();
            $table->boolean('card_checks_cvc_check')->nullable();
            $table->integer('amount_authorized')->nullable();
            $table->string('card_network')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
