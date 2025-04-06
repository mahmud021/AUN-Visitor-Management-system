<?php

use App\Models\User;
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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('telephone');

            $table->string('location')->nullable(); // New
            $table->text('purpose_of_visit')->nullable(); // New

            $table->string('token')->unique()->nullable();

            $table->date('visit_date')->nullable(); // Single date for the visit
            $table->time('start_time')->nullable(); // Start time on that date
            $table->time('end_time')->nullable();   // End time of visit

            $table->string('visitor_code', 4)->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'denied',
                'checked_in',
                'checked_out'
            ])->default('pending');

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamp('denied_at')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
