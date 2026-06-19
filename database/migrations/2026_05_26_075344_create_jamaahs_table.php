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
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('departure_schedule_id')->nullable()->constrained()->nullOnDelete();

            // Personal Data
            $table->string('name');
            $table->string('passport_name')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nik')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('city')->nullable();

            // Contact
            $table->string('whatsapp');
            $table->string('email')->nullable();

            // Documents (File paths)
            $table->string('ktp_file')->nullable();
            $table->string('passport_file')->nullable();
            $table->string('kk_file')->nullable();
            $table->string('payment_proof_file')->nullable();

            // Status
            $table->string('status')->default('Pending'); // Pending, DP, Lunas, Cancelled

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamaahs');
    }
};
