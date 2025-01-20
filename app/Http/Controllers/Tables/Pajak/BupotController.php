<?php

namespace App\Http\Controllers\Tables\Pajak;

use App\Exports\Pajak\LinkExport;
use App\Http\Controllers\Controller;
use App\Models\PublishFileNpwp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class BupotController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PublishFileNpwp::query())->toJson();
        }

        return view('pajak.cari-file.index');
    }

    public function findFile(Request $request)
    {
        $fileNpwp = PublishFileNpwp::find((int) $request->id);
        $files    = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $fileNpwp->file_path);
        $result   = [];
        foreach ($files as $f)
            if (str_contains($f, $fileNpwp->file_name)) {
                $result[] = File::dirname($f);
                break;
            }
        $filesExist = Storage::disk('public')->exists($result[0] . '/' . $fileNpwp->file_name);
        if ($filesExist) {
            $openBupot = $result[0] . '/' . $fileNpwp->file_name;

            return response()->file(Storage::disk('public')->path($openBupot, 200));
        }

        return false;
    }

    public function exportLink()
    {
        $name = 'link_bupot_' . Carbon::now();

        return Excel::download(new LinkExport, $name . '.xlsx');
    }
}
