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
            $table->string('user_type');
            $table->integer('seller_id');
            $table->string('product_name')->unique();
            $table->string('slug');
            $table->text('product_summary');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->double('product_price',10,2);
            $table->double('compare_price',10,2)->nullable();
            $table->String('product_image');
            $table->integer('visibility')->default(1);
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
