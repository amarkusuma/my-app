@extends('dashboard.authBase')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg bg-white" style="border-radius: 10px !important">
                {{-- <div class="card-header">{{ __('Reset Password') }}</div> --}}

                <div class="card-body">
                    <div class="text-center my-3">
                        <h4 class="font-weight-bold">Reset Password</h4>
                        <h6>Masukkan Password baru anda</h6>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('backend.reset_password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
    
                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-uppercase font-xs font-weight-bold">{{ __('New Password') }}</label>

                            <div class="col-md-12 col-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Silahkan masukkan password baru anda">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-12 col-form-label text-uppercase font-xs font-weight-bold">{{ __('Re-Enter New Password') }}</label>

                            <div class="col-md-12 col-12">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="password_confirmation" placeholder="Konfirmasi password baru anda">
                            </div>
                        </div>

                        <div class="form-group row mt-4 mb-4">
                            <div class="col-lg-6 col-md-6 col-12 offset-md-12 mx-auto">
                                <button type="submit" class="btn btn-primary w-100 py-2 font-lg font-weight-bold" style="border-radius: 20px !important">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
