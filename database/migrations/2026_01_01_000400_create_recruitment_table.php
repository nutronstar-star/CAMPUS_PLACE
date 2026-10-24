<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->integer('round_number');
            $table->string('round_name', 100)->nullable();
            $table->enum('mode', ['online', 'offline'])->default('online');
            $table->timestamp('scheduled_at');
            $table->integer('duration_minutes')->nullable();
            $table->string('venue')->nullable();
            $table->string('meeting_link')->nullable();
            $table->enum('result', ['pending', 'pass', 'fail', 'on_hold'])->default('pending');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->decimal('package', 10, 2)->nullable();
            $table->string('offer_letter_url')->nullable();
            $table->timestamp('acceptance_deadline')->nullable();
            $table->enum('status', ['released', 'accepted', 'rejected', 'expired', 'withdrawn'])->default('released');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
        Schema::create('placement_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->constrained();
            $table->decimal('package', 10, 2)->nullable();
            $table->enum('job_type', ['full_time', 'internship'])->default('full_time');
            $table->integer('placement_year');
            $table->boolean('is_multiple_offer')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('placement_records');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('interviews');
    }
};
