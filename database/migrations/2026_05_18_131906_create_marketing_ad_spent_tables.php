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
        // 1. Table for Ad Accounts
        Schema::create('ad_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // meta, tiktok, google
            $table->string('account_name'); // e.g. "Meta Akun Backup 1"
            $table->string('account_id'); // e.g. "act_1234567"
            $table->text('access_token');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Pivot table connecting Landing Pages to Ad Accounts (Many-to-Many)
        Schema::create('landing_page_ad_accounts', function (Blueprint $table) {
            $table->foreignId('landing_page_id')->constrained('landing_pages')->onDelete('cascade');
            $table->foreignId('ad_account_id')->constrained('ad_accounts')->onDelete('cascade');
            $table->primary(['landing_page_id', 'ad_account_id']);
        });

        // 3. Table for Daily Ad Spend and performance metrics
        Schema::create('daily_ad_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->nullable()->constrained('landing_pages')->onDelete('cascade');
            $table->foreignId('ad_account_id')->nullable()->constrained('ad_accounts')->onDelete('cascade');
            $table->date('report_date');
            $table->decimal('ad_spend', 14, 2)->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_ad_reports');
        Schema::dropIfExists('landing_page_ad_accounts');
        Schema::dropIfExists('ad_accounts');
    }
};
