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
            $table->timestamps(); // This adds 'created_at' and 'updated_at'

            // Additional columns from charge
            $table->integer('amount');
            $table->string('status');
            $table->string('email')->nullable();
            $table->string('receipt_url')->nullable();
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
