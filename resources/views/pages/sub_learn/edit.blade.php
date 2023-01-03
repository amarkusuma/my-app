@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Sub Learn Form</strong></h5>
                </div>

                <form method="POST" action="{{route('sub-learn.update', $data->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="learn_id" value="{{$learn_id}}">
                        <div class="form-group">
                            <label for="sub_name">Sub Name</label>
                            <input class="form-control @error('sub_name') is-invalid @enderror" value="{{$data->sub_name}}" name="sub_name" id="sub_name" type="text" placeholder="Input sub name">
                            @if($errors->has('sub_name'))
                                <div class="invalid-feedback">{{ $errors->first('sub_name') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="bank_soal_id">Bank Soal</label>
                            <select class="form-control @error('bank_soal_id') is-invalid @enderror" id="category" name="bank_soal_id">
                                <option value="0">Please select</option>
                                @foreach ($bank_soal as $item)
                                <option {{ $item->id == $data->bank_soal_id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bank_soal_id'))
                                <div class="invalid-feedback">{{ $errors->first('bank_soal_id') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="min_correct">Min Correct</label>
                            <input class="form-control @error('min_correct') is-invalid @enderror" value="{{$data->min_correct}}" name="min_correct" id="min_correct" type="text" placeholder="Input min correct">
                            @if($errors->has('min_correct'))
                                <div class="invalid-feedback">{{ $errors->first('min_correct') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pdf">PDF</label>
                            <input class="form-control @error('pdf') is-invalid @enderror" name="pdf" id="pdf" type="file" accept=".PDF,.pdf" placeholder="Input pdf">
                            @if($errors->has('pdf'))
                                <div class="invalid-feedback">{{ $errors->first('pdf') }}</div>
                            @endif
                            <div class="mt-2">
                                <a href="{{$data->pdf_url}}" target="_blank" rel="noopener noreferrer">File PDF</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="link_youtube">Link Youtube</label>
                            <input class="form-control @error('link_youtube') is-invalid @enderror" value="{{$data->link_youtube}}" name="link_youtube" id="link_youtube" type="text" placeholder="Input link youtube">
                            @if($errors->has('link_youtube'))
                                <div class="invalid-feedback">{{ $errors->first('link_youtube') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="limit_soal">Max Soal</label>
                            <input class="form-control @error('limit_soal') is-invalid @enderror" value="{{$data->limit_soal}}" name="limit_soal" id="limit_soal" type="text" placeholder="Input max soal">
                            @if($errors->has('limit_soal'))
                                <div class="invalid-feedback">{{ $errors->first('limit_soal') }}</div>
                            @endif
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <label class="c-switch c-switch-3d c-switch-primary">
                                <input class="c-switch-input" type="checkbox" name="activated" {{$data->activated ? 'checked' : ''}} ><span class="c-switch-slider"></span>
                            </label>
                            <label class="mx-3" for="discount-input">Activated</label>
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
