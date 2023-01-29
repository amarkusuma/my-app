@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Feedback Form</strong></h5>
                </div>

                <form method="POST" action="{{route('feedback.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="textarea-input">Feedback</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="textarea-input" rows="4" placeholder="comment.."></textarea>
                            @if($errors->has('comment'))
                                <div class="invalid-feedback">{{ $errors->first('comment') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('feedback.index')}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
