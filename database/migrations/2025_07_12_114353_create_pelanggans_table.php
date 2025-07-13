<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tarif')->nullable();
            $table->foreign('id_tarif')->references('id')->on('tarifs')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('nomor_kwh');
            $table->string('nama_pelanggan');
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
