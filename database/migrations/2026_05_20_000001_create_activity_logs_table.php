<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('subject_type')->nullable();          // e.g. "App\Models\Package"
            $table->unsignedBigInteger('subject_id')->nullable()->index();
            $table->string('action');                            // e.g. "created", "updated", "deleted", "status_changed"
            $table->json('before')->nullable();                  // State before mutation
            $table->json('after')->nullable();                   // State after mutation
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('channel')->default('activity');      // log channel label
            $table->timestamps();

            $table->index(['subject_type', 'subject_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
