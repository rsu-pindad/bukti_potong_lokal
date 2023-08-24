<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;

class PPH21Controller extends Controller
{


    public function calculate()
    {
        $statusPTKP = [
            'TK0' => 54000000,
            'TK1' => 58500000,
            'TK2' => 63000000,
            'TK3' => 67500000,
            'K0' => 58000000,
            'K1' => 63000000,
            'K2' => 67500000,
            'K3' => 72000000,
        ];
        $data = [];
    }
}
