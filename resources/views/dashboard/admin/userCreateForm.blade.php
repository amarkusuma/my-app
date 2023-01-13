@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                <div class="card">
                    
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> {{ __('Edit') }}
                  </div>
                  
                  <form method="POST" action="{{ route('users.store') }}">
                    <div class="card-body">
                      <br>
                      @csrf
                      @method('POST')
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                              <svg class="c-icon c-icon-sm">
                                  <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                              </svg>
                            </span>
                        </div>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="{{ __('Name') }}" name="name" required autofocus>
                        @if($errors->has('name'))
                          <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                      </div>
                      <div class="input-group mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text">@</span>
                          </div>
                          <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" required>
                          @if($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                          @endif
                      </div>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <svg class="c-icon c-icon-sm">
                                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                            </svg>
                          </span>
                        </div>
                        <select class="form-control @error('menuroles') is-invalid @enderror" id="menuroles" name="menuroles">
                          <option value="0">Please select</option>
                          @foreach ($menuroles as $item)
                          <option value="{{$item['value']}}">{{$item['label']}}</option>
                          @endforeach
                        </select>
                        @if($errors->has('menuroles'))
                            <div class="invalid-feedback">{{ $errors->first('menuroles') }}</div>
                        @endif
                      </div>
                    </div>
                    <div class="card-footer">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                      <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="cil-arrow-circle-left"></i> {{ __('Back') }}</a>
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