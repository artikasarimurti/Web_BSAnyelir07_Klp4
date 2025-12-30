<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_sampahs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('nasabah_id')->constrained()->onDelete('cascade');
        $table->enum('jenis_transaksi', ['setoran', 'penarikan']);
        $table->foreignId('jenis_id')->nullable()->constrained('jenis_sampah')->nullOnDelete();
        $table->decimal('kg', 10, 2)->default(0);
        $table->decimal('harga_per_kg', 15, 2)->default(0);
        $table->decimal('uang_masuk', 15, 2)->default(0);
        $table->decimal('uang_keluar', 15, 2)->default(0);
        $table->decimal('saldo', 15, 2);
        $table->string('paraf')->nullable();
        $table->date('tanggal');
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_sampahs');
    }
};
