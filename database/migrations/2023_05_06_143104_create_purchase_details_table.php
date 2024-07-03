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
            $table->unsignedBigInteger('purchase_id');
            $table->string('product_id');
            $table->integer('quantity');
            $table->integer('unitcost');
            $table->integer('total');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');

            // Additional columns from payment method details
            $table->string('payment_method_id');
            $table->string('card_brand');
            $table->string('card_last4');
            $table->integer('card_exp_month');
            $table->integer('card_exp_year');
            $table->string('card_fingerprint');
            $table->string('card_country');
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
