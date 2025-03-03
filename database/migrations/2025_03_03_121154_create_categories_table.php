<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Smartphone', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laptop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tablet', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Smartwatch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Desktop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Camera', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Printer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Headphone', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Speaker', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Monitor', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('brands')->insert([
            ['name' => 'Apple', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sony', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dell', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Canon', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Logitech', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'JBL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bose', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
    }
};
