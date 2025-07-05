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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string(column: 'title');
            $table->longText('description')->nullable();
            $table->longText('qualification')->nullable();
            $table->date('start_date');
            $table->date('deadline');
            $table->date('deadline_promotion');
            $table->text('provisions')->nullable();
            $table->decimal('price', 15, 2);
            $table->enum('status', ['open', 'in progress','on-hold' ,'completed', 'arbitrase-completed']);
            $table->integer('revisions');
            $table->text('category')->nullable();
            $table->string('job_file')->nullable();
            $table->boolean('status_affiliate')->nullable();
            $table->boolean('pengajuan_affiliate')->nullable();
            $table->decimal('harga_pajak_affiliate', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};