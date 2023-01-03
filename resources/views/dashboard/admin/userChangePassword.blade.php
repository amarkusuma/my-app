@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
            <div class="card">
                
                <div class="card-header">
                <i class="fa fa-align-justify"></i> {{ __('Change Password') }}
                </div>
                
                <form method="POST" action="{{ route('backend.change_password') }}">
                <div class="card-body">
                    <br>
                    @error('message')
                        <div class="error mb-3 text-center text-danger @error('message') is-invalid @enderror">{{ $message }}</div>
                    @enderror
                    @csrf
                    @method('POST')
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="cil-eyedropper"></i>
                            </span>
                        </div>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" required>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="cil-eyedropper"></i>
                            </span>
                        </div>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="{{ __('Password Confirmation') }}" name="password_confirmation" required>
                        @if($errors->has('password_confirmation'))
                            <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('javascript')

@endsection