<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('job_type', ['full_time', 'internship'])->default('full_time');
            $table->decimal('package_min', 10, 2)->nullable();
            $table->decimal('package_max', 10, 2)->nullable();
            $table->decimal('stipend', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->json('eligibility')->nullable();
            $table->timestamp('deadline');
            $table->enum('status', ['draft', 'active', 'closed', 'cancelled'])->default('draft');
            $table->timestamps();
        });
        Schema::create('job_colleges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->unique(['job_id', 'college_id']);
        });
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['applied', 'shortlisted', 'interview', 'selected', 'rejected', 'withdrawn'])->default('applied');
            $table->timestamps();
            $table->unique(['student_id', 'job_id']);
        });
        Schema::create('resume_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('resume_url');
            $table->integer('version')->default(1);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
        Schema::create('application_resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('resume_url');
            $table->integer('resume_version')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('application_resumes');
        Schema::dropIfExists('resume_versions');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('job_colleges');
        Schema::dropIfExists('jobs');
    }
};
