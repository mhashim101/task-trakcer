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
        Schema::create('attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->time('start_time')->default('09:00:00');
            $table->time('end_time')->default('17:00:00');
            $table->integer('late_threshold')->default(15); // minutes
            $table->integer('half_day_threshold')->default(4); // hours
            $table->json('working_days')->default(json_encode([1, 2, 3, 4, 5])); // Monday to Friday
            $table->json('holidays')->nullable(); // Array of holiday dates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_settings');
    }
};
