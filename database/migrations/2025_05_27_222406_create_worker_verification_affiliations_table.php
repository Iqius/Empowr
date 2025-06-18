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
        Schema::create('worker_verification_affiliations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('identity_photo');
            $table->string('selfie_with_id');
            $table->string('link_meet')->nullable();
            $table->text('keahlian_affiliate');
            $table->enum('status', ['pending', 'reviewed', 'Interview', 'result'])->default('pending');
            $table->enum('status_decision', ['approve', 'rejected', 'waiting'])->default('waiting');
            $table->datetime('jadwal_interview')->nullable();
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_verification_affiliations');
    }
};
