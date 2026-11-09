<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('company_name', 150);
            $table->string('location', 150)->nullable();
            $table->enum('job_type', ['magang', 'kontrak', 'penuh_waktu', 'paruh_waktu'])->default('magang');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->string('apply_link')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['status', 'deadline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};