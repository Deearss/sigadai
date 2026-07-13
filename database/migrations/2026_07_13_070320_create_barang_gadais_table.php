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
        Schema::create('barang_gadai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->enum('kategori', ['elektronik', 'kendaraan']);
            $table->unsignedBigInteger('taksiran_nilai');
            $table->string('nama_nasabah');
            $table->string('no_hp');
            $table->date('tanggal_gadai');
            $table->enum('status', ['aktif', 'ditebus', 'lelang'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_gadai');
    }
};
