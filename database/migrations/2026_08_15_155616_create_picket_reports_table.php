<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('picket_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('picket_schedule_id')->nullable()->constrained('picket_schedules')->nullOnDelete();
            $table->date('date');
            $table->string('proof_file');
            $table->text('notes')->nullable();
            $table->string('status')->default('submitted'); // submitted, verified, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('picket_reports');
    }
};
