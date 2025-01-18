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
        Schema::table('publish_file', function (Blueprint $table) {
            $table->mediumInteger('folder_jumlah_aone')->nullable(true)->default(0)->after('folder_jumlah_tidak_final');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publish_file', function (Blueprint $table) {
            $table->dropColumn('folder_jumlah_aone');
        });
    }
};
