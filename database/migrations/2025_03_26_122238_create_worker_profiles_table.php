<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
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
            $table->timestamp('affiliated_since')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('worker_verification_affiliations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('identity_photo');
            $table->string('selfie_with_id');
            $table->string('keahlian_affiliate');
            $table->enum('status', ['pending', 'reviewed', 'interview', 'approved', 'rejected']);
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });

        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id');
            $table->string('title');
            $table->text('description');
            $table->integer('duration');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });

        Schema::create('portfolio_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
        });

        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id');
            $table->string('title');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });

        Schema::create('sertifikasi_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sertifikasi_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('sertifikasi_id')->references('id')->on('sertifikasi')->onDelete('cascade');
        });

        Schema::create('certified_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->enum('status', ['application stage', 'viewed', 'selection test', 'interview selection', 'selection results']);
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('worker_profiles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certified_applications');
        Schema::dropIfExists('sertifikasi_images');
        Schema::dropIfExists('sertifikasi');
        Schema::dropIfExists('portfolio_images');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('worker_verification_affiliations');
        Schema::dropIfExists('task_applications');
        Schema::dropIfExists('task');            
        Schema::dropIfExists('worker_profiles');
    }
    
};