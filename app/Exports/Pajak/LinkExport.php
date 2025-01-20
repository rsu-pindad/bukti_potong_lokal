<?php

namespace App\Exports\Pajak;

use App\Models\PublishFileNpwp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LinkExport implements FromView
{
    public function view(): View
    {
        return view('pajak.cari-file.export.index', [
            'bupot' => PublishFileNpwp::select(['id', 'file_path', 'file_identitas_nama', 'short_link'])->get()
        ]);
    }
}
