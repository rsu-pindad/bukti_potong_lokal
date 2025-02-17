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
            $table->boolean('is_taken')->default(false)->after('epin');
            $table->unsignedBigInteger('user_id')->nullable()->default(null)->after('is_taken');
            $table->foreign('user_id')->references('id')->on('tbl_user')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // $table->dropIndex('employees_user_id_foreign');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('is_taken');
            // $table->dropColumn('user_id');
        });
    }
};
