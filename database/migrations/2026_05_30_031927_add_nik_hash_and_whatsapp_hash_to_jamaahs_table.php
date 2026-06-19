<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add deterministic hash columns for NIK and WhatsApp to allow secure
     * database lookups without exposing the encrypted PII values.
     * Uses HMAC-SHA256 with APP_KEY as the HMAC secret for collision resistance.
     */
    public function up(): void
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->string('nik_hash', 64)->nullable()->index()->after('nik')
                ->comment('HMAC-SHA256 of NIK used for login lookup — never store raw NIK in queries');
            $table->string('whatsapp_hash', 64)->nullable()->index()->after('whatsapp')
                ->comment('HMAC-SHA256 of normalized WhatsApp number for login lookup');
        });
    }

    public function down(): void
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->dropColumn(['nik_hash', 'whatsapp_hash']);
        });
    }
};
