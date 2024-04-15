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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('small_description');
            $table->string('description');
            $table->unsignedBigInteger('category_id'); 
            $table->unsignedBigInteger('unit_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('product_code')->nullable();
            $table->integer('stock');
            $table->boolean('isActive')->default(true);
            $table->json('materials')->nullable();
            $table->integer('buying_price')->nullable();
            $table->integer('selling_price')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('difficulty')->nullable()->unsigned()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
