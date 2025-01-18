<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nik')->nullable(false)->change();
            $table->string('npp_baru')->nullable()->after('npp');
            $table->renameColumn('status_pegawai', 'status_kepegawaian');
            $table->string('tmt_masuk')->nullable()->after('no_hp');
            $table->string('tmt_keluar')->nullable()->after('tmt_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nik')->nullable(true)->change();
            $table->renameColumn('status_kepegawaian', 'status_pegawai');
            $table->dropColumn('npp_baru');
            $table->dropColumn('tmt_masuk');
            $table->dropColumn('tmt_keluar');
        });
    }
};
