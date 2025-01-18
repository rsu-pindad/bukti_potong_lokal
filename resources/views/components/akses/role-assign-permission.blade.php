@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="d-flex flex-column p-4 m-2">
        <h2>Pilih permisi untuk role <b>{{$role->name}} </b>
            <a href="{{url()->previous()}}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-square-fill"></i>
            </a>
        </h2>
        <form action="{{ route('role-assign-permission', ['id' => $role->id]) }}" method="post" class="form-control">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    @foreach ($list_permission as $items)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$items->name}}" id="{{$items->id}}" name="permisi[]" @if($role_has_permission->contains($items->name)) checked @endif>
                        <label class="form-check-label" for="{{$items->id}}">
                            {{$items->name}}
                        </label>
                    </div>
                    @endforeach
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
    </div>
</div>

@endsection
