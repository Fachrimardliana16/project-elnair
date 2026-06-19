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
        // 1. Create Groups table
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departure_schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('muthowif')->nullable();
            $table->string('pembimbing')->nullable();
            $table->string('bus_number')->nullable();
            $table->string('booking_code')->nullable();
            $table->string('flight_code')->nullable();
            $table->dateTime('flight_departure_time')->nullable();
            $table->string('flight_transit')->nullable();
            $table->string('flight_terminal')->nullable();
            $table->integer('capacity')->default(45);
            $table->timestamps();
        });

        // 2. Add columns to Jamaahs table
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->after('departure_schedule_id')->constrained('groups')->nullOnDelete();
            $table->string('vaccine_file')->nullable()->after('kk_file');
            $table->string('photo_file')->nullable()->after('vaccine_file');
            $table->enum('room_type', ['Quad', 'Triple', 'Double'])->default('Quad')->after('photo_file');
            $table->string('visa_status')->default('Belum Diajukan')->after('status');
        });

        // 3. Create Payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jamaah_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['DP', 'Cicilan 1', 'Cicilan 2', 'Pelunasan']);
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });

        // 4. Create Rooms table
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->string('hotel_name'); // e.g. Makkah Hotel / Madinah Hotel
            $table->string('room_number');
            $table->timestamps();
        });

        // 5. Create Room Members table
        Schema::create('room_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jamaah_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_members');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('payments');

        Schema::table('jamaahs', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn(['group_id', 'vaccine_file', 'photo_file', 'room_type', 'visa_status']);
        });

        Schema::dropIfExists('groups');
    }
};
