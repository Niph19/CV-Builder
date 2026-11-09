<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('jurusan', 100);
            $table->year('tahun_lulus');
            $table->enum('status_saat_ini', ['bekerja', 'kuliah', 'wirausaha', 'mencari_kerja', 'lainnya']);
            $table->string('nama_instansi', 150)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->index('tahun_lulus');
            $table->index('status_saat_ini');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};