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
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->id();

            // If the timeline event is related to a visitor record
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');

            // The user who performed the action (student/staff, HR, or security)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // The type of event (for example: 'created', 'approved', 'checked_in', 'checked_out')
            $table->string('event_type');

            // A brief description or title for the event
            $table->string('description')->nullable();

            // Additional details or comments about the event
            $table->text('details')->nullable();

            // When the event actually occurred (if different from created_at)
            $table->timestamp('occurred_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
