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
        Schema::table('tbl_gaji', function (Blueprint $table) {
            $table->double('tj_lainnya')->nullable()->after('tj_bhy');
            $table->double('jm_potongan')->nullable()->after('pot_swk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_gaji');
    }
};
