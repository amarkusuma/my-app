@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>News Category Form</strong></h5>
                </div>

                <form method="POST" action="{{route('learns.update', $data->id)}}">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" value="{{$data->name}}" name="name" id="name" type="text" placeholder="Input name">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="level-input">Level</label>
                            {{-- <input class="form-control @error('level') is-invalid @enderror" value="{{$data->level}}" name="level" type="number" id="level" placeholder="Input level" /> --}}
                            <select class="form-control @error('level') is-invalid @enderror" id="category" name="level">
                                <option value="0">Please select</option>
                                @foreach ($level as $item)
                                <option {{ $data->level == $item['value'] ? 'selected' : ''}} value="{{$item['value']}}">{{$item['label']}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('level'))
                                <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price-input">Price</label>
                            <input class="form-control @error('price') is-invalid @enderror" value="{{$data->price}}" name="price" type="number" id="price" placeholder="Input price" />
                            @if($errors->has('price'))
                                <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="discount-input">Discount</label>
                            <input class="form-control @error('discount') is-invalid @enderror" value="{{$data->discount}}" name="discount" type="number" id="discount" placeholder="Input discount" />
                            @if($errors->has('discount'))
                                <div class="invalid-feedback">{{ $errors->first('discount') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('learns.index')}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
