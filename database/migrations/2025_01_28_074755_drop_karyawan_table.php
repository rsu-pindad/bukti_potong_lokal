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
        Schema::dropIfExists('karyawan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('tbl_user')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('npp')->unique()->nullable();
            $table->string('nama')->nullable();
            $table->string('st_ptkp')->nullable();
            $table->string('npwp')->unique()->nullable();
            $table->string('st_peg')->nullable();
            $table->boolean('user_edited')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }
};
