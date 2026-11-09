<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vacancy_id')->nullable()->constrained('job_vacancies')->nullOnDelete();
            $table->string('company_name', 150);
            $table->string('position', 150);
            $table->date('applied_at');
            $table->enum('status', ['diproses', 'wawancara', 'diterima', 'ditolak'])->default('diproses');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('cv_id')->nullable(); // FK ke cvs (Alief) ditambah belakangan
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};