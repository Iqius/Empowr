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
        Schema::create('worker_verification_affiliation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliation_id');
            $table->unsignedBigInteger('action_admin')->nullable(); // nullable kalau boleh kosong
            $table->enum('status_decision', ['waiting','approved', 'rejected'])->default('waiting');
            $table->enum('status', ['pending', 'reviewed', 'Interview', 'result']);
            $table->timestamps();

            $table->foreign('affiliation_id')->references('id')->on('worker_verification_affiliations')->onDelete('cascade');
            $table->foreign('action_admin')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_verification_affiliations_logs');
    }
};
