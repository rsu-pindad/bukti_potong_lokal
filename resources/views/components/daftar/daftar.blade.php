@props(['route', 'showSelf'])
<main class="form-signin mx-auto my-auto w-auto">
  @if ($route === 'cari' && $showSelf === false)
    <div class="card">
      <div class="card-header text-center">
        <h4>Daftar</h4>
      </div>
      <div class="card-body p-auto">
        <form action="{{ route('cari-npp') }}"
              method="post">
          @csrf
          <div class="row">
            <div class="col">
              <x-forms.floating-labels name="npp"
                                       label="NPP">
                <x-inputs.input id="npp"
                                name="npp"
                                placeholder="npp...." />
              </x-forms.floating-labels>
            </div>
          </div>
          <hr class="border-secondary border border-2 opacity-25">
          <div class="row">
            <div class="col text-center">
              <x-inputs.button type="submit"
                               class="btn btn-primary">
                Cari NPP
                <i class="fa-solid fa-magnifying-glass"></i>
              </x-inputs.button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <ul class="list-group list-group-horizontal d-flex justify-content-between">
          <li class="list-group-item">
            <a href="/"
               class="text-decoration-none">
              <i class="fa-solid fa-chevron-left"></i>
              login
            </a>
          </li>
        </ul>
      </div>
    </div>
  @endif
  @if ($route === 'daftar' && $showSelf === true)
    <div class="card">
      <div class="card-header text-center">
        <h4>Daftar</h4>
      </div>
      <div class="card-body p-2">
        <form action="{{ route('daftar-store') }}"
              method="post">
          @csrf

          <div class="d-flex flex-column">
            <div class="row mx-4">
              <div class="col">
                <x-forms.floating-labels name="npp"
                                         label="NPP">
                  <x-inputs.input id="npp"
                                  name="npp"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('npp') }}"
                                  placeholder="npp...."
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
              <div class="col">
                <x-forms.floating-labels name="nik"
                                         label="NIK">
                  <x-inputs.input id="nik"
                                  name="nik"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('nik') }}"
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
            </div>
            <div class="row mx-4">
              <div class="col">
                <x-forms.floating-labels name="npwp"
                                         label="NPWP">
                  <x-inputs.input id="npwp"
                                  name="npwp"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('npwp') }}"
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
              <div class="col">
                <x-forms.floating-labels name="email"
                                         label="Email">
                  <x-inputs.input id="email"
                                  name="email"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('email') }}"
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
            </div>
            <div class="row mx-4">
              <div class="col">
                <x-forms.floating-labels name="no_hp"
                                         label="No NP">
                  <x-inputs.input id="np_hp"
                                  name="np_hp"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('no_hp') }}"
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
              <div class="col">
                <x-forms.floating-labels name="status_ptkp"
                                         label="PTKP">
                  <x-inputs.input id="status_ptkp"
                                  name="status_ptkp"
                                  class="form-control-plaintext"
                                  value="{{ session()->get('status_ptkp') }}"
                                  readonly="true" />
                </x-forms.floating-labels>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column">
            <hr class="border-secondary border border-2 opacity-25">
            <div class="row mx-4">
              <div class="input-group">
                <x-forms.floating-labels name="otp"
                                         label="OTP">
                  <x-inputs.input id="otp"
                                  name="otp"
                                  placeholder="masukan OTP" />

                  <x-inputs.button id="sendOTPCODE"
                                   type="button"
                                   class="btn btn-info">
                    Dapatkan OTP
                  </x-inputs.button>
                  <div id="otpHelper"
                       class="form-text">otp akan dikirimkan via whatsapp, pastikan no hp terdaftar whatsapp</div>
                </x-forms.floating-labels>
              </div>
            </div>
            <hr class="border-secondary border border-2 opacity-25">
            <div class="row mx-4">
              <x-forms.floating-labels name="username"
                                       label="Username">
                <x-inputs.input id="username"
                                name="username"
                                placeholder="username...." />
                <div id="username"
                     class="form-text">min:5, max:15.</div>
              </x-forms.floating-labels>
            </div>
            <hr class="border-secondary border border-2 opacity-25">
            <div class="row mx-4">
              <x-forms.floating-labels name="password"
                                       label="Password">
                <x-inputs.input id="password"
                                type="password"
                                name="password"
                                placeholder="password...." />
                <div id="password"
                     class="form-text">min:6.</div>
              </x-forms.floating-labels>
            </div>
            <div class="row mx-4">
              <x-forms.floating-labels name="password_confirmation"
                                       label="Ulangi password">
                <x-inputs.input id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="username...." />
                <div id="password_confirmation"
                     class="form-text">min:6.</div>
              </x-forms.floating-labels>
            </div>
            <hr class="border-secondary border border-2 opacity-25">
            <div class="row mx-4">
              <div class="col text-center">
                <x-inputs.button type="submit"
                                 class="btn btn-primary">
                  Daftar
                </x-inputs.button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <ul class="list-group list-group-horizontal d-flex justify-content-between">
          <li class="list-group-item">
            <a href="{{ route('cari-index') }}">kembali</a>
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

@once
  @push('styles')
    <style>
      html,
      body {
        height: 100%;
      }

      .form-signin {
        /* max-width: 330px; */
        max-width: auto;
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
  @push('scripts')
    <script type="module">
      document.addEventListener("DOMContentLoaded", () => {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });

        $('#sendOTPCODE').on('click', function(e) {
          e.preventDefault();
          // $(this).attr("disabled", "disabled");
          // $(this).text("Kirim Ulang");
          // $('#otpHelper').text("Otp Sudah dikirim");
          // let results;
          $.ajax({
            url: "{{ route('send-otp') }}",
            type: 'POST',
            data: {
              "_token": "{{ csrf_token() }}",
            }
            success: function(result) {
              // console.log(result);
              // return result.status;
              if (result.status == 'terkirim') {
                // alert('ok');
                localStorage.setItem('hasSendOtp', 'dikirim');
                location.reload();
              } else {
                alert('Terjadi Kesalahan')
              }
            }
          });
          // console.log(results);
        });

        if (localStorage.getItem('hasSendOtp') === 'dikirim') {
          // localStorage.setItem('hasSendOtp', 'true');
          // $('#sendOTPCODE').attr("disabled", "disabled");
          $('#sendOTPCODE').text("Kirim Ulang");
          $('#otpHelper').text("Otp Sudah dikirim");
        }

      });
    </script>
  @endpush
@endonce
