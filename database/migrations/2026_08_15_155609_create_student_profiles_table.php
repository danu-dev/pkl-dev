<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('school_id')->nullable()->constrained('schools')->nullOnDelete();
            $table->foreignId('major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->foreignId('pkl_batch_id')->nullable()->constrained('pkl_batches')->nullOnDelete();
            $table->string('nisn_nim')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cv_path')->nullable();
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->string('session_type')->default('full_day'); // full_day, persesi_pagi, persesi_sore
            $table->string('division_name')->nullable();
            $table->string('school_name')->nullable();
            $table->string('major_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
