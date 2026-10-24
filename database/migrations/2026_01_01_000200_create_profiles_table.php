<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('enrollment_no', 50);
            $table->decimal('cgpa', 4, 2)->nullable();
            $table->integer('backlogs')->default(0);
            $table->integer('passing_year')->nullable();
            $table->json('skills')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('status', ['active', 'placed', 'blacklisted', 'graduated'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['college_id', 'enrollment_no']);
            $table->index(['college_id', 'status']);
        });
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('industry', 100)->nullable();
            $table->string('hr_name', 150)->nullable();
            $table->string('hr_email')->nullable();
            $table->string('hr_phone', 15)->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'blacklisted'])->default('pending');
            $table->foreignId('global_approved_by')->nullable()->constrained('users');
            $table->timestamp('global_approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('students');
    }
};
