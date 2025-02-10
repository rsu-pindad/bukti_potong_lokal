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
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(true)->after('epin');
            $table->boolean('is_edited')->default(false)->nullable()->after('user_id');
            $table->foreign('user_id')->references('id')->on('tbl_user')->constrained();
        });
        Schema::dropIfExists('karyawan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('employees_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('is_edited');
        });
    }
};
