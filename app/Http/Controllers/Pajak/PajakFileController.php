<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use App\Models\PublishFile;
use App\Models\PublishFileNpwp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZanySoft\Zip\Facades\Zip;
use ZanySoft\Zip\ZipManager;

class PajakFileController extends Controller
{
    public function index()
    {
        $zip_files = Storage::disk('public')->files('files/shares/pajak');

        return view('pajak.bukti-potong.pajak-file')->with([
            'title'     => 'Publish Pajak',
            'zip_files' => $zip_files
        ]);
    }

    public function publish(Request $request)
    {
        return view('pajak.bukti-potong.pajak-publish')->with([
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

        if ($validator->fails()) {
            flash()
                ->error($validator->errors()->first())
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        $locationZip          = Storage::disk('public')->path('files/shares/pajak/' . $validator->safe()->namaFile);
        $newDirectory         = Storage::disk('public')->makeDirectory('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        $markDirectoryPublish = Storage::disk('public')->makeDirectory('files/shares/pajak/publish/' . $validator->safe()->namaFile . '/' . $validator->safe()->bulan . $validator->safe()->tahun);
        $emptyFolder          = Storage::disk('public')->files('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        if (count($emptyFolder) > 0) {
            flash()
                ->error('folder tidak kosong, mohon kosongkan folder di file manager')
                ->flash();

            return redirect()->back();
        }
        $getTargetExtrack = Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
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

            $publishedFile = PublishFile::create([
                'folder_uniq'    => Str::random(25),
                'folder_path'    => $getTargetExtrack,
                'folder_publish' => $validator->safe()->namaFile,
                'folder_name'    => $validator->safe()->bulan . $validator->safe()->tahun,
                'folder_status'  => false,
            ]);

            flash()
                ->success('file berhasil di publish')
                ->flash();

            return redirect()->route('pajak-file-index');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back();
        }
    }

    public function unPublish(Request $request)
    {
        $folder         = $request->nama_file;
        $folder_path    = Storage::disk('public')->directories('files/shares/pajak/publish/' . $folder);
        $published_file = $request->folder_target;
        try {
            Storage::disk('public')->deleteDirectory('files/shares/pajak/publish/' . $folder);
            Storage::disk('public')->deleteDirectory('files/shares/pajak/extrack/' . $published_file);
            $deletePublish = PublishFile::where('folder_name', $request->folder_target);
            $filenpwp      = $deletePublish->first()->id;
            PublishFileNpwp::where('publish_file_id', $filenpwp)->forceDelete();
            $deletePublish->forceDelete();
            flash()
                ->success('folder berhasil di unpublished')
                ->flash();

            return redirect()->route('pajak-file-index');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back();
        }
    }

    public function uploadBuktiPotong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buktiPotong' => 'required|max:120000|mimes:zip,x-zip-compressed'
        ]);
        if ($validator->fails()) {
            flash()
                ->error($validator->errors()->first())
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }
        $files = $request->file('buktiPotong');

        try {
            $request->buktiPotong->move(public_path('storage/files/shares/pajak/'), time() . '_' . $files->getClientOriginalName());
            flash()
                ->success('file berhasil di publish')
                ->flash();

            return redirect()->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back();
        }
    }

    public function removeBuktiPotong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filename' => 'required'
        ]);
        if ($validator->fails()) {
            flash()
                ->error('validasi error')
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }
        try {
            Storage::disk('public')->delete('files/shares/pajak/' . $request->input('filename'));
            flash()
                ->success('folder berhasil di unpublished')
                ->flash();

            return redirect()->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back();
        }
    }
}
