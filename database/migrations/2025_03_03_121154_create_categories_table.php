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
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users');
        });

        DB::table('categories')->insert([
            ['code' => 'SPP' . date('YmdHis'), 'name' => 'Smartphone', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LPP' . date('YmdHis'), 'name' => 'Laptop', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'TBV' . date('YmdHis'), 'name' => 'Tablet', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SWV' . date('YmdHis'), 'name' => 'Smartwatch', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'DTT' . date('YmdHis'), 'name' => 'Desktop', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'CMV' . date('YmdHis'), 'name' => 'Camera', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'PRR' . date('YmdHis'), 'name' => 'Printer', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'HPR' . date('YmdHis'), 'name' => 'Headphone', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SPG' . date('YmdHis'), 'name' => 'Speaker', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'MHN' . date('YmdHis'), 'name' => 'Monitor', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('brands')->insert([
            ['code' => 'APL' . date('YmdHis'), 'name' => 'Apple', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SMS' . date('YmdHis'), 'name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SNY' . date('YmdHis'), 'name' => 'Sony', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'DLL' . date('YmdHis'), 'name' => 'Dell', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'HPP' . date('YmdHis'), 'name' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'CNA' . date('YmdHis'), 'name' => 'Canon', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LOG' . date('YmdHis'), 'name' => 'Logitech', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'JBL' . date('YmdHis'), 'name' => 'JBL', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LGG' . date('YmdHis'), 'name' => 'LG', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'BSE' . date('YmdHis'), 'name' => 'Bose', 'created_at' => now(), 'updated_at' => now()],
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
