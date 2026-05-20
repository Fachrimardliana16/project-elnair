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
        Schema::table('packages', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->text('itinerary')->nullable()->after('description');
            $table->string('hotel_makkah')->nullable()->after('itinerary');
            $table->string('hotel_madinah')->nullable()->after('hotel_makkah');
            $table->string('maskapai')->nullable()->after('hotel_madinah');
            $table->text('fasilitas')->nullable()->after('maskapai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['slug', 'itinerary', 'hotel_makkah', 'hotel_madinah', 'maskapai', 'fasilitas']);
        });
    }
};
