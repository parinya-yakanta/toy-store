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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('original_price')->default(0);
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimension')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
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
