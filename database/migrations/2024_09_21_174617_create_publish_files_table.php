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
        Schema::create('publish_file', function (Blueprint $table) {
            $table->id();
            $table->string('folder_uniq');
            $table->string('folder_path');
            $table->string('folder_publish');
            $table->string('folder_name');
            $table->boolean('folder_status')->default(0);
            $table->mediumInteger('folder_jumlah_final')->nullable()->default(0);
            $table->mediumInteger('folder_jumlah_tidak_final')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publish_file');
    }
};
