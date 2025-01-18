@extends('layout.main')
@section('content')

    <div class="container-fluid">
        <div class="d-flex flex-column p-4 m-2">
            <h2>Edit Permisi
                <a href="{{url()->previous()}}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-square-fill"></i>
                </a>
            </h2>
            <form action="{{route('permission-update', ['id' => $list_permission->id])}}" method="post">
                @method('PATCH')
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <x-forms.floating-labels id="name" label="Nama permisi">
                            <x-inputs.input
                                id="name"
                                name="name"
                                value="{{$list_permission->name}}"
                                placeholder="nama permisi..."
                                required
                            />
                        </x-forms.floating-labels>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <x-inputs.button
                            type="submit"
                            class="btn btn-primary"
                            >
                            <i class="bi bi-pencil-square"></i>
                        </x-inputs.button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection