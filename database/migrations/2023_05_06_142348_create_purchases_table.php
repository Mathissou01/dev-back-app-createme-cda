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
        Schema::create('purchases', function (Blueprint $table) {
           $table->id();
            $table->string('purchaseId')->unique();
            $table->string('supplier_id');
            $table->string('purchase_date');
            $table->string('purchase_no');
            $table->char('purchase_status', 1)->default(0)->comment('0=Pending, 1=Approved');
            $table->integer('total_amount');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->integer('amount');
            $table->string('status');
            $table->string('email')->nullable();
            $table->string('receipt_url')->nullable();
            $table->string('payment_intent')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('captured');
            $table->boolean('paid');
            $table->string('currency', 3);
            $table->string('billing_name')->nullable();
            $table->string('billing_address_line1')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_country')->nullable();
            $table->string('billing_address_postal_code')->nullable();
            $table->string('outcome_network_status')->nullable();
            $table->string('outcome_type')->nullable();
            $table->integer('risk_score')->nullable();
            $table->string('seller_message')->nullable();
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
