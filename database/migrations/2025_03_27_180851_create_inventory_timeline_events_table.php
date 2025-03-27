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
        Schema::create('inventory_timeline_events', function (Blueprint $table) {
            $table->id();

            // Foreign key to the "inventories" table
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

            // The user who performed the action
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // The type of event (e.g. 'created', 'checked_in', 'checked_out', 'moved', etc.)
            $table->string('event_type');

            // A brief description or title of the event
            $table->string('description')->nullable();

            // More details about the event, if necessary
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
        Schema::dropIfExists('inventory_timeline_events');
    }
};
