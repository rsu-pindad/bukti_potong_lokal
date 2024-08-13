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
                    // Local
                    // $folder = Storage::directories('public/files/shares/pajak/publish/' . $itemName['4']);
                    // VPS
                    $folder = Storage::directories('files/shares/pajak/publish/' . $itemName['3']);
                    if(count($folder) > 0){
                    $folderExplode = explode('/', $folder['0']);
                    // Local
                    // $folderTanggal = $folderExplode['6'];
                    // VPS
                    $folderTanggal = $folderExplode['5'];
                    }
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        {{-- local --}}
                        {{-- <td>{{$itemName['4']}}</td> --}}
                        {{-- vps --}}
                        <td>{{$itemName['3']}}</td>
                        @if(count($folder) > 0) 
                        <td>{{$folderTanggal}}</td>
                        <td>
                            <p>
                                dipublish
                            </p>
                            <p>
                                <form action="{{route('pajak-unpublish')}}" method="post">
                                    @csrf
                                    {{-- Local --}}
                                    {{-- <input type="hidden" name="nama_file" value="{{$itemName['4']}}"> --}}
                                    {{-- VPS --}}
                                    <input type="hidden" name="nama_file" value="{{$itemName['3']}}">
                                    <input type="hidden" name="folder_target" value="{{$folderTanggal}}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </p>
                        </td>
                        @else
                        <td>-</td>
                        <td>
                            {{-- Local --}}
                            {{-- <a href="{{route('pajak-publish', ['filename' => $itemName['4']])}}" class="btn btn-primary">
                                Set
                            </a> --}}
                            {{-- VPS --}}
                            <a href="{{route('pajak-publish', ['filename' => $itemName['3']])}}" class="btn btn-primary">
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
