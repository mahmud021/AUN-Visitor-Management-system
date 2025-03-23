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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('appliance_name');
            $table->string('brand');
            $table->string('location')->nullable();
            $table->enum('status', [
                'pending',
                'checked_in',
                'missing',
                'checked_out'
            ])->default('pending');
            $table->string('image_path')->nullable(); // Added field for storing image path
            $table->timestamp('checked_in_at')->useCurrent();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
