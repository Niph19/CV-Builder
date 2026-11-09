<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->string('nama_lengkap', 150)->nullable()->after('user_id');
        });

        DB::table('alumni_profiles')->whereNull('nama_lengkap')->update([
            'nama_lengkap' => DB::raw('(select name from users where users.id = alumni_profiles.user_id)'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni_profiles', function (Blueprint $table) {
            $table->dropColumn('nama_lengkap');
        });
    }
};
