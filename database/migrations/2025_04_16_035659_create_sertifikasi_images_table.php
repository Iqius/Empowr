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
        Schema::create('sertifikasi_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikasi_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('sertifikasi_id')->references('id')->on('sertifikasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi_images');
    }
};
