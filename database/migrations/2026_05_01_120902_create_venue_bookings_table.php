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
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->id();

            // Who is booking
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();

            // What it's for
            $table->string('purpose');
            $table->text('description')->nullable();
            $table->string('organizer_name');
            $table->string('organizer_phone');
            $table->string('organizer_email');
            $table->integer('expected_attendees')->default(0);

            // When
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');

            // Status flow: pending → approved → rejected
            $table->string('status')->default('pending')->enum(['approved'], ['rejected'], ['pending']);

            // Approval
            $table->foreignId('approved_by')->nullable()
                ->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Unique booking reference
            $table->string('reference_number')->unique()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_bookings');
    }
};
