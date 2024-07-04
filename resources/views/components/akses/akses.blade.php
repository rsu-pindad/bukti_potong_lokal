@extends('layout.main')
@section('content')

    <div class="container-fluid">
        <div class="d-flex flex-column p-4 m-2">
            <h2>List Akses</h2>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_akses->items() as $akses)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$akses->username}}</td>
                            <td>{{$akses->getRoleNames()}}</td>
                            <td>
                                <a href="{{route('akses-role-show', ['id' => $akses->id])}}"
                                    class="btn btn-md btn-outline-success"
                                    role="button"
                                    >
                                    <i class="bi bi-key-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {!! $list_akses->onEachSide(2)->links() !!}
            </div>
        </div>
    </div>

@endsection