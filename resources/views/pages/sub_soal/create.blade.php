@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Sub Soal Form</strong></h5>
                </div>

                <form method="POST" action="{{route('sub-soal.store')}}">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="bank_soal_id" value="{{$bank_soal_id}}">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input class="form-control @error('question') is-invalid @enderror" name="question" id="question" type="text" placeholder="Input question">
                            @if($errors->has('question'))
                                <div class="invalid-feedback">{{ $errors->first('question') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="correct_answer">Correct Answer</label>
                            <input class="form-control @error('correct_answer') is-invalid @enderror" name="correct_answer" id="correct_answer" type="text" placeholder="Input correct_answer">
                            @if($errors->has('correct_answer'))
                                <div class="invalid-feedback">{{ $errors->first('correct_answer') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_A">Option A</label>
                            <input class="form-control @error('option_A') is-invalid @enderror" name="option_A" id="option_A" type="text" placeholder="Input option A">
                            @if($errors->has('option_A'))
                                <div class="invalid-feedback">{{ $errors->first('option_A') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_B">Option B</label>
                            <input class="form-control @error('option_B') is-invalid @enderror" name="option_B" id="option_B" type="text" placeholder="Input option B">
                            @if($errors->has('option_B'))
                                <div class="invalid-feedback">{{ $errors->first('option_B') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_C">Option C</label>
                            <input class="form-control @error('option_C') is-invalid @enderror" name="option_C" id="option_C" type="text" placeholder="Input option C">
                            @if($errors->has('option_C'))
                                <div class="invalid-feedback">{{ $errors->first('option_C') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="option_D">Option D</label>
                            <input class="form-control @error('option_D') is-invalid @enderror" name="option_D" id="option_D" type="text" placeholder="Input option D">
                            @if($errors->has('option_D'))
                                <div class="invalid-feedback">{{ $errors->first('option_D') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('sub-soal.index', $bank_soal_id)}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
