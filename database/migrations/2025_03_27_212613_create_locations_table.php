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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            // Optionally add other fields like description or status
            $table->timestamps();
        });

        DB::table('locations')->insert([
            [
                'name'       => 'Library',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Admin 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Admin 1 / Student Hub',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'POH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Commencement Hall',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'SAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'SOE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'SOL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm AA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm BB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm CC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm DD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm EE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dorm FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Aisha Kande',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Gabrreile Volpi Boys',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Rossaiare Volpi Girls',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Cafeteria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
