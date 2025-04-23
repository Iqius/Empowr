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
        Schema::create('worker_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('tingkat_keahlian', ['Beginner', 'Intermediate', 'Expert'])->nullable();
            $table->text('keahlian')->nullable();
            $table->boolean('empowr_label')->default(false);
            $table->boolean('empowr_affiliate')->default(false);
            $table->string('cv')->nullable();
            $table->text('pengalaman_kerja')->nullable();
            $table->text('pendidikan')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_diperbarui')->useCurrent();
            $table->string('keahlian_affiliate')->nullable();
            $table->string('identity_photo')->nullable();
            $table->string('selfie_with_id')->nullable();
            $table->string('linkedin')->nullable();
            $table->timestamp('affiliated_since')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_profiles');
    }
};
