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
        Schema::create('tbl_gaji', function (Blueprint $table) {
            $table->id();
            $table->string('npp')->nullable();
            $table->string('nama')->nullable();
            $table->integer('st_peg')->nullable();
            $table->string('st_kelu')->nullable();
            $table->string('st_beras')->nullable();
            $table->string('st_ptkp')->nullable();
            $table->string('gol_gapok')->nullable();
            $table->double('gapok')->nullable();
            $table->double('tj_kelu')->nullable();
            $table->double('nl_bruto')->nullable();
            $table->double('tj_jbt')->nullable();
            $table->double('tj_kesja')->nullable();
            $table->double('tj_profesi')->nullable();
            $table->double('tj_beras')->nullable();
            $table->double('tj_rayon')->nullable();
            $table->double('tj_didik')->nullable();
            $table->double('tj_bhy')->nullable();
            $table->double('tj_hadir')->nullable();
            $table->double('tj_alih')->nullable();
            $table->double('rapel')->nullable();
            $table->double('lembur')->nullable();
            $table->double('kurang')->nullable();
            $table->double('lebih')->nullable();
            $table->double('pt_pph21')->nullable();
            $table->double('tpp')->nullable();
            $table->double('tpu')->nullable();
            $table->double('cuti')->nullable();
            $table->double('thr')->nullable();
            $table->date('bulan')->nullable();

            $table->timestamps();
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
