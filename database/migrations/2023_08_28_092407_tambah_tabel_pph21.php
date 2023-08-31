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
            $table->double('tunjangan');
            $table->double('premi_as');
            $table->double('tj_pajak');
            $table->double('bruto');
            $table->double('biaya_jabatan');
            $table->double('iuran_pensiun');
            $table->double('potongan');
            $table->double('total_potongan');
            $table->double('neto_sebulan');
            $table->double('neto_setahun');
            $table->double('ptkp');
            $table->double('pkp');
            $table->double('pph21_setahun');
            $table->double('pph21_sebulan');
            $table->date('tgl_pph21');
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
