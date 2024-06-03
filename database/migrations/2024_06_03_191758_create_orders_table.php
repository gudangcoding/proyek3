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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('so_no')->nullable()->unique();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->string('kelas_pelanggan_id')->nullable()->constrained();
            $table->string('kategori_pelanggan_id')->nullable()->constrained();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('diskon', 18, 2)->nullable();
            $table->decimal('ongkir', 18, 2)->nullable();
            $table->decimal('grand_total', 18, 2)->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
