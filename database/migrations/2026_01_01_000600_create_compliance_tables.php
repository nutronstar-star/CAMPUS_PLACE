<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('dpdp_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('consent_type', ['data_collection', 'data_sharing', 'marketing']);
            $table->boolean('consented')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('consented_at')->nullable();
            $table->timestamps();
        });
        Schema::create('dpdp_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accessed_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('data_owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('data_type', 50);
            $table->string('purpose')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
        Schema::create('aicte_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained()->cascadeOnDelete();
            $table->string('certificate_url')->nullable();
            $table->string('registration_number', 100)->nullable();
            $table->string('address_proof_url')->nullable();
            $table->enum('verification_method', ['manual', 'api'])->default('manual');
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('aicte_verifications');
        Schema::dropIfExists('dpdp_access_logs');
        Schema::dropIfExists('dpdp_consents');
    }
};
