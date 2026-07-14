<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week'); // 0=Sun, 1=Mon ... 6=Sat
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();
            $table->string('color', 7)->nullable(); // hex e.g. #2563EB
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_schedules');
    }
};