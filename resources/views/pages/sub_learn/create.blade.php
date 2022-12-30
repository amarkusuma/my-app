@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Sub Learn Form</strong></h5>
                </div>

                <form method="POST" action="{{route('sub-learn.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="learn_id" value="{{$learn_id}}">
                        <div class="form-group">
                            <label for="sub_name">Sub Name</label>
                            <input class="form-control @error('sub_name') is-invalid @enderror" name="sub_name" id="sub_name" type="text" placeholder="Input sub_name">
                            @if($errors->has('sub_name'))
                                <div class="invalid-feedback">{{ $errors->first('sub_name') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="bank_soal_id">Bank Soal</label>
                            <select class="form-control @error('bank_soal_id') is-invalid @enderror" id="category" name="bank_soal_id">
                                <option value="0">Please select</option>
                                @foreach ($bank_soal as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bank_soal_id'))
                                <div class="invalid-feedback">{{ $errors->first('bank_soal_id') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="min_correct">Min Correct</label>
                            <input class="form-control @error('min_correct') is-invalid @enderror" name="min_correct" id="min_correct" type="text" placeholder="Input min_correct">
                            @if($errors->has('min_correct'))
                                <div class="invalid-feedback">{{ $errors->first('min_correct') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pdf">PDF</label>
                            {{-- <input class="form-control @error('pdf') is-invalid @enderror" name="pdf" id="pdf" type="text" placeholder="Input pdf"> --}}
                            <input class="form-control @error('pdf') is-invalid @enderror" name="pdf" id="pdf" type="file" accept=".PDF,.pdf" placeholder="Input pdf">
                            @if($errors->has('pdf'))
                                <div class="invalid-feedback">{{ $errors->first('pdf') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="link_youtube">Link Youtube</label>
                            <input class="form-control @error('link_youtube') is-invalid @enderror" name="link_youtube" id="link_youtube" type="text" placeholder="Input link_youtube">
                            @if($errors->has('link_youtube'))
                                <div class="invalid-feedback">{{ $errors->first('link_youtube') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('sub-learn.index', $learn_id)}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
