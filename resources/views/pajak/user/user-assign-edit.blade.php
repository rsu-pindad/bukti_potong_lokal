@extends('layout.main')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
        <h4>Data User</h4>
    </div>
    <div class="card-body">
        <div class="card-title">
            <a href="{{ route('pajak-employee-index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-chevron-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div>
            <form action="{{ route('pajak-user-assign-remove', ['id' => $employee->id]) }}" method="post">
                @csrf
                @method('delete')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input id="username" class="form-control @error('username') is-invalid @enderror" name="nik" value="{{ $user->username }}" readonly>
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-danger">
                                Lepas User
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection