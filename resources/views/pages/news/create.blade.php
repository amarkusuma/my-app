@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>News Form</strong></h5>
                </div>

                <form method="POST" action="{{route('news.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input class="form-control @error('title') is-invalid @enderror" name="title" id="title" type="text" placeholder="Input title">
                            @if($errors->has('title'))
                                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('news_category_id') is-invalid @enderror" id="category" name="news_category_id">
                                <option value="0">Please select</option>
                                @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->category}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('news_category_id'))
                                <div class="invalid-feedback">{{ $errors->first('news_category_id') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="author_by">Author</label>
                            <input class="form-control @error('author_by') is-invalid @enderror" name="author_by" id="author_by" type="text" placeholder="Input author by">
                            @if($errors->has('author_by'))
                                <div class="invalid-feedback">{{ $errors->first('author_by') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" name="image" id="image" type="file" placeholder="Input image">
                            @if($errors->has('image'))
                                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="textarea-input">Textarea</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="textarea-input" name="textarea-input" rows="5" placeholder="Description.."></textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('news.index')}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
