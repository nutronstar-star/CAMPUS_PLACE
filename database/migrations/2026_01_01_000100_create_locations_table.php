<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 10)->unique();
            $table->timestamps();
        });
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('state_id')->constrained();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('principal_name', 150)->nullable();
            $table->string('tpo_name', 150)->nullable();
            $table->string('tpo_contact', 15)->nullable();
            $table->integer('total_students')->default(0);
            $table->string('naac_grade', 10)->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected', 'blacklisted'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['state_id', 'status']);
        });
        Schema::create('college_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->string('designation', 100)->default('TPO');
            $table->boolean('is_backup')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'college_id']);
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('code', 20);
            $table->timestamps();
            $table->unique(['college_id', 'name']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('college_admins');
        Schema::dropIfExists('colleges');
        Schema::dropIfExists('states');
    }
};
