@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> User {{ $user->name }}
                  </div>
                  <div class="card-body">
                      <h4>Name: {{ $user->name }}</h4>
                      <h4>E-mail: {{ $user->email }}</h4>
                  </div>
                  <div class="card-footer">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">{{ __('Return') }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection