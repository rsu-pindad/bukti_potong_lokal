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
        Schema::create('tbl_pph21', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npp');
            $table->string('nama');
            $table->double('gapok');
            $table->double('tunjangan');
            $table->double('premi_as');
            $table->double('thr');
            $table->double('bonus');
            $table->double('tj_pajak');
            $table->double('bruto');
            $table->double('penghasilan');
            $table->double('biaya_jabatan');
            $table->double('iuran_pensiun');
            $table->double('potongan');
            $table->double('ptkp');
            $table->double('pkp');
            $table->double('pph21_setahun');
            $table->double('pph21_sebulan');
            $table->date('tgl_gaji');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pph21');
    }
};
