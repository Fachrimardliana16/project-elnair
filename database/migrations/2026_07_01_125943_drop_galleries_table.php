<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('galleries');
    }

    public function down(): void
    {
        Schema::create('galleries', function ($table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }
};
