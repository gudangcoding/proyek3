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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('produk_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('satuan')->nullable();
            $table->decimal('harga', 16, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('koli')->nullable();
            $table->integer('jumlah_koli')->nullable()->default(1);
            $table->decimal('subtotal', 16, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
