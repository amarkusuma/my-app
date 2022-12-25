@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>{{ __('News Category') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn btn-primary" href="{{ route('news-category.create') }}">Add category</a>
                            </div>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th class="text-center" colspan="3">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data as $key => $item)
                            <tr>
                                <td>{{$key +=1}}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <a href="{{ url('/news-category/' . $item->id) }}" class="btn btn-block btn-primary">View</a>
                                </td>
                                <td>
                                    <a href="{{ url('/news-category/' . $item->id . '/edit') }}" class="btn btn-block btn-primary">Edit</a>
                                </td>
                                <td>
                                    <form action="{{ route('news-category.destroy', $item->id ) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-block btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection
