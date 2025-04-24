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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('deadline');
            $table->date('deadline_promotion');
            $table->text('provisions')->nullable();
            $table->decimal('price', 15, 2);
            $table->enum('status', ['open', 'in progress', 'completed']);
            $table->integer('revisions');
            $table->enum('taskType', ['web_development',
            'mobile_development',
            'game_development',
            'software_engineering',
            'frontend_development',
            'backend_development',
            'full_stack_development',
            'devops',
            'qa_testing',
            'automation_testing',
            'api_integration',
            'wordpress_development',
            'data_science',
            'machine_learning',
            'ai_development',
            'data_engineering',
            'data_entry',
            'seo',
            'content_writing',
            'technical_writing',
            'blog_writing',
            'copywriting',
            'scriptwriting',
            'proofreading',
            'translation',
            'transcription',
            'resume_writing',
            'ghostwriting',
            'creative_writing',
            'social_media_management',
            'digital_marketing',
            'email_marketing',
            'affiliate_marketing',
            'influencer_marketing',
            'community_management',
            'search_engine_marketing',
            'branding',
            'graphic_design',
            'ui_ux_design',
            'logo_design',
            'motion_graphics',
            'illustration',
            'video_editing',
            'video_production',
            'animation',
            '3d_modeling',
            'video_game_design',
            'audio_editing',
            'photography',
            'photo_editing',
            'presentation_design',
            'project_management',
            'virtual_assistant',
            'customer_service',
            'lead_generation',
            'market_research',
            'business_analysis',
            'human_resources',
            'event_planning',
            'bookkeeping',
            'accounting',
            'tax_preparation',
            'financial_analysis',
            'legal_advice',
            'contract_drafting',
            'startup_consulting',
            'investment_research',
            'real_estate_consulting',
            'personal_assistant',
            'clerical_work',
            'data_analysis',
            'business_coaching',
            'career_coaching',
            'life_coaching',
            'consulting',
            'other'
            ])->nullable();
            $table->string('job_file')->nullable();
            $table->boolean('bayar')->default(false);
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
