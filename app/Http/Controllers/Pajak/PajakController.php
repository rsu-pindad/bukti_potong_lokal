<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZanySoft\Zip\ZipManager;
use Zip;

class PajakController extends Controller
{
    public function index()
    {
        $zip_files = Storage::files('public/files/shares/pajak');

        return view('pajak.pajak-file')->with([
            'title'     => 'Publish Pajak',
            'zip_files' => $zip_files
        ]);
    }

    public function publish(Request $request)
    {
        return view('pajak.pajak-publish')->with([
            'title'     => 'Publish Pajak',
            'nama_file' => $request->filename
        ]);
    }

    public function published(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaFile' => 'required',
            'bulan'    => 'required|numeric',
            'tahun'    => 'required|numeric'
        ]);

        $request->session()->reflash();
        if ($validator->fails()) {
            flash()
                ->error('validasi error')
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        $locationZip          = storage_path('app/public/files/shares/pajak/' . $validator->safe()->namaFile);
        $newDirectory         = Storage::makeDirectory('public/files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        $markDirectoryPublish = Storage::makeDirectory('public/files/shares/pajak/publish/' . $validator->safe()->namaFile . '/' . $validator->safe()->bulan . $validator->safe()->tahun);
        $emptyFolder          = Storage::allFiles('public/files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);

        if (count($emptyFolder) > 0) {
            flash()
                ->error('folder tidak kosong, mohon kosongkan folder di file manager')
                ->flash();

            return redirect()->back();
        }
        $getTargetExtrack = storage_path('app/public/files/shares/pajak/extrack/') . $validator->safe()->bulan . $validator->safe()->tahun;
        $is_valid         = Zip::check($locationZip);
        if (!$is_valid) {
            flash()
                ->error('zip tidak valid')
                ->flash();

            return redirect()->back();
        }

        try {
            $manager = new ZipManager();
            $manager->addZip(Zip::open($locationZip));
            $extrack = $manager->extract($getTargetExtrack, true);
            $manager->close();
            flash()
                ->success('file berhasil di publish')
                ->flash();

            return redirect()->route('pajak-index');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back();
        }
    }
}
