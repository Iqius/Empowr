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
            $table->enum('keahlian_affiliate', [
                'Web Development',
                'Mobile Development',
                'Game Development',
                'Software Engineering',
                'Frontend Development',
                'Backend Development',
                'Full Stack Development',
                'DevOps',
                'QA Testing',
                'Automation Testing',
                'API Integration',
                'WordPress Development',
                'Data Science',
                'Machine Learning',
                'AI Development',
                'Data Engineering',
                'Data Entry',
                'SEO',
                'Content Writing',
                'Technical Writing',
                'Blog Writing',
                'Copywriting',
                'Scriptwriting',
                'Proofreading',
                'Translation',
                'Transcription',
                'Resume Writing',
                'Ghostwriting',
                'Creative Writing',
                'Social Media Management',
                'Digital Marketing',
                'Email Marketing',
                'Affiliate Marketing',
                'Influencer Marketing',
                'Community Management',
                'Search Engine Marketing',
                'Branding',
                'Graphic Design',
                'UI/UX Design',
                'Logo Design',
                'Motion Graphics',
                'Illustration',
                'Video Editing',
                'Video Production',
                'Animation',
                '3D Modeling',
                'Video Game Design',
                'Audio Editing',
                'Photography',
                'Photo Editing',
                'Presentation Design',
                'Project Management',
                'Virtual Assistant',
                'Customer Service',
                'Lead Generation',
                'Market Research',
                'Business Analysis',
                'Human Resources',
                'Event Planning',
                'Bookkeeping',
                'Accounting',
                'Tax Preparation',
                'Financial Analysis',
                'Legal Advice',
                'Contract Drafting',
                'Startup Consulting',
                'Investment Research',
                'Real Estate Consulting',
                'Personal Assistant',
                'Clerical Work',
                'Data Analysis',
                'Business Coaching',
                'Career Coaching',
                'Life Coaching',
                'Consulting',
                'Other'
            ]);
            $table->enum('status', ['pending', 'reviewed', 'Interview', 'result'])->default('pending');
            $table->enum('status_decision', ['approve', 'rejected', 'waiting'])->default('waiting');
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
