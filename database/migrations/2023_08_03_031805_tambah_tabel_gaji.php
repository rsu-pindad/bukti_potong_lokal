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
            $table->string('st_peg')->nullable();
            $table->string('st_kelu')->nullable();
            $table->string('st_beras')->nullable();
            $table->string('st_ptkp')->nullable();
            $table->double('gapok')->nullable();
            $table->double('tj_kelu')->nullable();
            $table->double('tj_pend')->nullable();
            $table->double('nl_bruto1')->nullable();
            $table->double('tj_jbt')->nullable();
            $table->double('tj_alih')->nullable();
            $table->double('tj_kesja')->nullable();
            $table->double('tj_beras')->nullable();
            $table->double('tj_rayon')->nullable();
            $table->double('tj_makan')->nullable();
            $table->double('tj_sostek')->nullable();
            $table->double('tj_kes')->nullable();
            $table->double('tj_dapen')->nullable();
            $table->double('tj_hadir')->nullable();
            $table->double('tj_bhy')->nullable();
            $table->double('lembur')->nullable();
            $table->double('kurang')->nullable();
            $table->double('jm_hasil')->nullable();
            $table->double('tj_pph21')->nullable();
            $table->date('tgl_gaji')->nullable();
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
