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
        Schema::table('publish_file_npwp', function (Blueprint $table) {
            $table->string('short_link')->nullable()->default(null)->after('file_identitas_alamat');
            $table->string('original_link')->nullable()->default(null)->after('short_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publish_file_npwp', function (Blueprint $table) {
            $table->dropColumn('short_link');
            $table->dropColumn('original_link');
        });
    }
};
