<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['deadline', 'shortlist', 'interview', 'offer', 'result', 'announcement']);
            $table->enum('channel', ['in_app', 'email', 'both'])->default('both');
            $table->boolean('is_critical')->default(false);
            $table->boolean('read_status')->default(false);
            $table->timestamps();
        });
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 100);
            $table->string('entity_type', 50)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
        Schema::create('blacklist_colleges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->text('reason');
            $table->foreignId('blacklisted_by')->constrained('users');
            $table->timestamps();
        });
        Schema::create('blacklist_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->text('reason');
            $table->enum('scope', ['national', 'college'])->default('national');
            $table->foreignId('college_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('blacklisted_by')->constrained('users');
            $table->timestamps();
        });
        Schema::create('blacklist_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->text('reason');
            $table->foreignId('blacklisted_by')->constrained('users');
            $table->timestamps();
        });
        Schema::create('company_college_blacklist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->foreignId('blacklisted_by')->constrained('users');
            $table->timestamps();
            $table->unique(['company_id', 'college_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('company_college_blacklist');
        Schema::dropIfExists('blacklist_students');
        Schema::dropIfExists('blacklist_companies');
        Schema::dropIfExists('blacklist_colleges');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
    }
};
