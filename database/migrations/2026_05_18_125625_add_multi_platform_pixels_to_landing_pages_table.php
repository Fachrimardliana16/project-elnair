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
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('fb_pixel_id')->nullable()->after('pixel_script');
            $table->text('fb_capi_token')->nullable()->after('fb_pixel_id');
            $table->string('tiktok_pixel_id')->nullable()->after('fb_capi_token');
            $table->text('tiktok_capi_token')->nullable()->after('tiktok_pixel_id');
            $table->string('snack_pixel_id')->nullable()->after('tiktok_capi_token');
            $table->string('google_pixel_id')->nullable()->after('snack_pixel_id');
            $table->string('google_conversion_label')->nullable()->after('google_pixel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'fb_pixel_id',
                'fb_capi_token',
                'tiktok_pixel_id',
                'tiktok_capi_token',
                'snack_pixel_id',
                'google_pixel_id',
                'google_conversion_label'
            ]);
        });
    }
};
