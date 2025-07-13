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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tagihan')->nullable();
            $table->foreign('id_tagihan')->references('id')->on('tagihans')->onDelete('cascade');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->unsignedTinyInteger('bulan');
            $table->integer('biaya_admin');
            $table->decimal('total_bayar', 10, 2);
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
