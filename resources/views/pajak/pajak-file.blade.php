@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <h3>Data File Pajak</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-light table-bordered table-hover table-striped" id="filePajakTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Status Publish</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($zip_files as $item)
                    @php
                    $itemName = explode('/',$item);
                    $folder = Storage::directories('public/files/shares/pajak/publish/' . $itemName['4']);
                    if(count($folder) > 0){
                    $folderExplode = explode('/', $folder['0']);
                    $folderTanggal = $folderExplode['6'];
                    }
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$itemName['4']}}</td>
                        @if(count($folder) > 0) 
                        <td>{{$folderTanggal}}</td>
                        <td>
                            <p>
                                dipublish
                            </p>
                            <p>
                                <form action="{{route('pajak-unpublish')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="nama_file" value="{{$itemName['4']}}">
                                    <input type="hidden" name="folder_target" value="{{$folderTanggal}}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </p>
                        </td>
                        @else
                        <td>-</td>
                        <td>
                            <a href="{{route('pajak-publish', ['filename' => $itemName['4']])}}" class="btn btn-primary">
                                Set
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
