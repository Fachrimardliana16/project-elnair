<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $バランス) {
            $バランス->string('role')->default('user')->after('password');
        });

        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tagline')->nullable();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('btn_primary_text')->nullable();
            $table->string('btn_primary_url')->nullable();
            $table->string('btn_secondary_text')->nullable();
            $table->string('btn_secondary_url')->nullable();
            $table->string('background_image')->nullable();
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('price_label');
            $table->string('price_value');
            $table->text('description');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_label');
            $table->text('quote');
            $table->string('avatar')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::dropIfExists('hero_settings');
        Schema::dropIfExists('features');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('site_settings');
    }
};
