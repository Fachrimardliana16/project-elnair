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
            if (!Schema::hasColumn('landing_pages', 'custom_wa_number')) {
                $table->string('custom_wa_number')->nullable()->after('content');
            }
            if (!Schema::hasColumn('landing_pages', 'custom_wa_message')) {
                $table->text('custom_wa_message')->nullable()->after('custom_wa_number');
            }
            if (!Schema::hasColumn('landing_pages', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('custom_wa_message');
            }
            if (!Schema::hasColumn('landing_pages', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('landing_pages', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('landing_pages', 'custom_wa_number')) {
                $columns[] = 'custom_wa_number';
            }
            if (Schema::hasColumn('landing_pages', 'custom_wa_message')) {
                $columns[] = 'custom_wa_message';
            }
            if (Schema::hasColumn('landing_pages', 'hero_image')) {
                $columns[] = 'hero_image';
            }
            if (Schema::hasColumn('landing_pages', 'meta_title')) {
                $columns[] = 'meta_title';
            }
            if (Schema::hasColumn('landing_pages', 'meta_description')) {
                $columns[] = 'meta_description';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
