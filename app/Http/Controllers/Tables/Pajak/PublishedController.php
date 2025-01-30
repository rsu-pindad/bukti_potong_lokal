<?php

namespace App\Http\Controllers\Tables\Pajak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublishFile;
use Yajra\DataTables\Facades\DataTables;
// 
class PublishedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $published = PublishFile::with('hashPublished')->findOrFail(intval($request->file));
            return DataTables::of($published->hashPublished())->toJson();
        }

        return view('pajak.bukti-potong.pajak-published-file-name');
    }
}
