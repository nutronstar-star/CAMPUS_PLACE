<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('ads_config', function (Blueprint $table) {
            $table->id();
            $table->string('publisher_id', 50)->nullable();
            $table->string('ad_slot_student', 50)->nullable();
            $table->string('ad_slot_company', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('ad_impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('ad_slot', 50);
            $table->string('page', 100);
            $table->enum('action', ['impression', 'click'])->default('impression');
            $table->timestamps();
        });
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('success')->default(false);
            $table->timestamp('attempted_at')->useCurrent();
        });
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->string('to_email');
            $table->string('subject');
            $table->text('body');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->integer('attempts')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('state_college_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->unique()->constrained()->cascadeOnDelete();
            $table->integer('total_colleges')->default(0);
            $table->integer('verified_colleges')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('state_college_counts');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('email_queue');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('ad_impressions');
        Schema::dropIfExists('ads_config');
    }
};
