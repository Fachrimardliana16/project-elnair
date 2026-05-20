<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page_leads', function (Blueprint $table) {
            // UTM Attribution columns
            $table->string('utm_source')->nullable()->after('status');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_content')->nullable()->after('utm_campaign');
            $table->string('utm_term')->nullable()->after('utm_content');

            // Forensic tracking columns
            $table->string('ip_address', 45)->nullable()->after('utm_term');
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('referrer')->nullable()->after('user_agent');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page_leads', function (Blueprint $table) {
            $table->dropColumn([
                'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
                'ip_address', 'user_agent', 'referrer',
            ]);
        });
    }
};
