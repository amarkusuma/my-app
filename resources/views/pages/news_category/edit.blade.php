@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>News Category Form</strong></h5>
                </div>

                <form method="POST" action="{{route('news-category.update', $data->id)}}">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input class="form-control @error('category') is-invalid @enderror" value="{{$data->category}}" name="category" id="category" type="text" placeholder="Input category">
                            @if($errors->has('category'))
                                <div class="invalid-feedback">{{ $errors->first('category') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="textarea-input">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="textarea-input" rows="4" placeholder="Description..">{{$data->description}}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('news-category.index')}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
