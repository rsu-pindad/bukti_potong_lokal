<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PublishFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class UserDokumenController extends Controller
{
    public function index(Request $request)
    {
        $publishedFile = PublishFile::select(['id', 'folder_name'])->find($request->id);
        $searchDir = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $arrayDir = array_filter($searchDir, function ($value) use ($publishedFile) {
            return $value;
        });
        $searchDir = array_filter($arrayDir);
        $files     = [];
        foreach ($searchDir as $dir) {
            $files[] = Storage::disk('public')->allFiles($dir);
        }
        $files = Arr::flatten($files);
        $resultFile;
        foreach ($files as $key => $value) {
            if (str_contains($value, $request->name)) {
                $resultFile = $files[$key];
                break;
            } else {
                $resultFile = '';
            }
        }

        return response()->download(Storage::disk('public')->path($resultFile, 200));
    }
}
