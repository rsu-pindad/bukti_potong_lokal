@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="d-flex flex-column p-4 m-2">
        <h2>List Role
            <x-inputs.button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRole">
                <i class="fa-solid fa-circle-plus"></i>
            </x-inputs.button>
        </h2>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list_role->items() as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                    <td class="d-flex">
                        <div>
                            <form action="{{route('role-destroy', ['id'=>$item->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <x-inputs.button type="submit" class="btn btn-md btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </x-inputs.button>
                            </form>
                        </div>
                        <div class="px-2">
                            <a href="{{route('role-edit', ['id' => $item->id])}}"
                                class="btn btn-md btn-outline-primary"
                                role="button"
                                >
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </div>
                        <div>
                            <a href="{{route('role-show-permission', ['id' => $item->id])}}"
                                class="btn btn-md btn-outline-success"
                                role="button"
                                >
                                <i class="fa-solid fa-key"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {!! $list_role->onEachSide(2)->links() !!}
        </div>
    </div>
</div>

@endsection

@pushOnce('modals')
<x-modal.default-inner rootId="addRole" rootLabel="Tambah Role" class="">
    <form action="{{ route('role-store')}}" method="post">
        @csrf
        <div class="row mb-2">
            <div class="col">
                <x-forms.floating-labels name="nama_role" label="Role">
                    <x-inputs.input id="name" name="name" placeholder="Masukan nama role..." required />
                </x-forms.floating-labels>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-inputs.button type="submit" class="btn btn-primary">
                    Simpan
                </x-inputs.button>
            </div>
        </div>
    </form>
</x-modal.default-inner>
@endPushOnce
