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
            $table->dropColumn('folder_jumlah_final');
            $table->dropColumn('folder_jumlah_tidak_final');
            $table->dropColumn('folder_jumlah_aone');
            $table->mediumInteger('folder_jumlah_file')->nullable()->default(0)->after('folder_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publish_file', function (Blueprint $table) {
            $table->mediumInteger('folder_jumlah_final')->nullable()->default(0)->after('folder_status');
            $table->mediumInteger('folder_jumlah_tidak_final')->nullable()->default(0)->after('folder_jumlah_final');
            $table->mediumInteger('folder_jumlah_aone')->nullable()->default(0)->after('folder_jumlah_tidak_final');
            $table->dropColumn('folder_jumlah_file');
        });
    }
};
