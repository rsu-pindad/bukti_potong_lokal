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
        Schema::create('publish_file_npwp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publish_file_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_identitas_npwp')->nullable();
            $table->string('file_identitas_nik')->nullable();
            $table->string('file_identitas_nama')->nullable();
            $table->string('file_identitas_alamat')->nullable();
            $table
                ->foreign('publish_file_id')
                ->references('id')
                ->on('publish_file')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publish_file_npwp');
    }
};
