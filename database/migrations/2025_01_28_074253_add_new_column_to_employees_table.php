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
            $table->unsignedBigInteger('user_id')->nullable()->after('epin');
            $table->boolean('is_taken')->nullable(true)->default(false)->after('user_id');
            $table->boolean('is_active')->nullable(true)->default(false)->after('is_taken');
            $table->boolean('is_aggree')->nullable(true)->default(false)->after('is_active');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('tbl_user')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->drop('user_id');
            $table->dropColumn('is_taken');
            $table->dropColumn('is_active');
            $table->dropColumn('is_aggree');
        });
    }
};
