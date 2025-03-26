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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->time('visitor_start_time')->nullable();
            $table->time('visitor_end_time')->nullable();
            $table->timestamps();
        });
        DB::table('app_settings')->insert([
            'visitor_start_time' => '08:00:00',
            'visitor_end_time'   => '17:00:00',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
