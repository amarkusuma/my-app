@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>Menu roles</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <a class="btn btn btn-primary" href="{{ route('roles.create') }}">Add new role</a>
                    </div>
                </div>
                <br>
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hierarchy</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th style="width: 20%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    {{ $role->name }}
                                </td>
                                <td>
                                    {{ $role->hierarchy }}
                                </td>
                                <td>
                                    {{ $role->created_at }}
                                </td>
                                <td>
                                    {{ $role->updated_at }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-success mr-2" href="{{ route('roles.up', ['id' => $role->id]) }}">
                                            <i class="cil-arrow-thick-top"></i>
                                        </a>
                                        <a class="btn btn-success mr-2" href="{{ route('roles.down', ['id' => $role->id]) }}">
                                            <i class="cil-arrow-thick-bottom"></i>
                                        </a>
                                        <a href="{{ route('roles.show', $role->id ) }}" class="btn btn-primary mr-2">Show</a>
                                        <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-primary mr-2">Edit</a>
                                    
                                        <form action="{{ route('roles.destroy', $role->id ) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
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
</div>

@endsection

@section('javascript')

@endsection
