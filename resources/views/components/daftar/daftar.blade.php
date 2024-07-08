@props(['route', 'showSelf'])
<main class="form-signin w-100 m-auto">
    @if($route === 'cari' && $showSelf === false)
    <div class="card">
        <div class="card-header text-center fw-3 fw-bold">Cari NPP</div>
        <div class="card-body p-auto">
            <form action="{{route('cari-npp')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <x-forms.floating-labels name="npp" label="NPP">
                            <x-inputs.input id="npp" name="npp" placeholder="npp...." />
                        </x-forms.floating-labels>
                    </div>
                </div>
                <hr class="border border-secondary border-2 opacity-25">
                <div class="row">
                    <div class="col text-center">
                        <x-inputs.button type="submit" class="btn btn-primary">
                            Cari NPP
                        </x-inputs.button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="list-group list-group-horizontal d-flex justify-content-between">
                <li class="list-group-item">
                    <a href="/">login</a>
                </li>
            </ul>
        </div>
    </div>
    @endif
    @if($route === 'daftar' && $showSelf === true)
    <div class="card">
        <div class="card-header text-center fw-3 fw-bold">Daftar</div>
        <div class="card-body p-auto">
            <form action="{{route('daftar-store')}}" method="post">
                @csrf
                <div class="row">
                    <x-forms.floating-labels name="npp" label="NPP">
                        <x-inputs.input id="npp" name="npp" class="form-control-plaintext" value="{{session()->get('npp')}}" placeholder="npp...." readonly="true" />
                    </x-forms.floating-labels>
                </div>
                <div class="row">
                    <x-forms.floating-labels name="username" label="Username">
                        <x-inputs.input id="username" name="username" placeholder="username...." />
                    </x-forms.floating-labels>
                </div>
                <hr class="border border-secondary border-2 opacity-25">
                <div class="row">
                    <x-forms.floating-labels name="password" label="Password">
                        <x-inputs.input type="password" id="password" name="password" placeholder="password...." />
                    </x-forms.floating-labels>
                </div>
                <div class="row">
                    <x-forms.floating-labels name="password_confirmation" label="Ulangi password">
                        <x-inputs.input type="password" id="password_confirmation" name="password_confirmation" placeholder="username...." />
                    </x-forms.floating-labels>
                </div>
                <hr class="border border-secondary border-2 opacity-25">
                <div class="row">
                    <div class="col text-center">
                        <x-inputs.button type="submit" class="btn btn-primary">
                            Daftar
                        </x-inputs.button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="list-group list-group-horizontal d-flex justify-content-between">
                <li class="list-group-item">
                    <a href="{{route('cari-index')}}">kembali</a>
                </li>
                <li class="list-group-item">
                    <a href="/">login</a>
                </li>
            </ul>
        </div>
    </div>
    @endif
    </div>
</main>

@push('styles')
<style>
    html,
    body {
        height: 100%;
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="text"] {
        margin-bottom: 10px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

</style>
@endpush
