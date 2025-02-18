@extends('layout.main')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between flex-row">
        <h4>Assign User Pegawai</h4>
    </div>
    <div class="card-body">
        <div class="card-title">
            <a href="{{ route('pajak-user-index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-chevron-left mr-2"></i>
                Kembali
            </a>
        </div>
        <div>
            <form action="{{ route('pajak-user-assign', ['id' => $user->id]) }}" method="post">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" class="form-control" name="id" value="{{ $user->id }}" readonly>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input id="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" readonly>
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="form-floating">
                                <select class="form-select" name="userSelect" aria-label="User Select">
                                    <option selected hidden>Pilih User</option>
                                    @foreach($karyawan as $k)
                                    <option value="{{$k->id}}">{{$k->nama}} / NPP Lama : {{$k->npp}} / NPP Baru : {{$k->npp_baru}}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelect">Pilih user</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">
                                Assign
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection