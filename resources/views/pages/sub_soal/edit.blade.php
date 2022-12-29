@extends('dashboard.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><strong>Sub Soal Form</strong></h5>
                </div>

                <form method="POST" action="{{route('sub-soal.update', $data->id)}}">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="bank_soal_id" value="{{$data->bank_soal_id}}">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input class="form-control @error('question') is-invalid @enderror" value="{{$data->question}}" name="question" id="question" type="text" placeholder="Input question">
                            @if($errors->has('question'))
                                <div class="invalid-feedback">{{ $errors->first('question') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_A">Option A</label>
                            <input class="form-control @error('option_A') is-invalid @enderror" value="{{$data->option_A}}" name="option_A" id="option_A" type="text" placeholder="Input option A">
                            @if($errors->has('option_A'))
                                <div class="invalid-feedback">{{ $errors->first('option_A') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_B">Option B</label>
                            <input class="form-control @error('option_B') is-invalid @enderror" value="{{$data->option_B}}" name="option_B" id="option_B" type="text" placeholder="Input option B">
                            @if($errors->has('option_B'))
                                <div class="invalid-feedback">{{ $errors->first('option_B') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="option_C">Option C</label>
                            <input class="form-control @error('option_C') is-invalid @enderror" value="{{$data->option_C}}" name="option_C" id="option_C" type="text" placeholder="Input option C">
                            @if($errors->has('option_C'))
                                <div class="invalid-feedback">{{ $errors->first('option_C') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="option_D">Option D</label>
                            <input class="form-control @error('option_D') is-invalid @enderror" value="{{$data->option_D}}" name="option_D" id="option_D" type="text" placeholder="Input option D">
                            @if($errors->has('option_D'))
                                <div class="invalid-feedback">{{ $errors->first('option_D') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="correct_answer">Correct Answer</label>
                            <select class="form-control @error('correct_answer') is-invalid @enderror" {} name="correct_answer" id="correct_answer">
                                <option value="0">Please select</option>
                                @foreach ($options as $item)
                                    <option {{ $data->correct_answer == $item['value'] ? 'selected' : ''}} id="{{$item['id']}}" value="{{$item['value']}}">{{$item['value']}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('correct_answer'))
                                <div class="invalid-feedback">{{ $errors->first('correct_answer') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn btn-primary" type="submit"> Submit</button>
                        <a href="{{route('sub-soal.index', $data->bank_soal_id)}}" class="btn btn btn-secondary" type="button"><i class="cil-arrow-circle-left"></i> Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>

        var select = [];
        const data = "{{ json_encode($options) }}";
        select = JSON.parse(data.replace(/&quot;/g,'"'));
        // console.log(JSON.parse(data.replace(/&quot;/g,'"')));

        $(`input[name='option_A']`).on('keyup', function(){
            if($(`input[name='option_A']`).val()) {
                $('select[name=correct_answer]').empty();
                select[0] = {
                    value: $(`input[name='option_A']`).val(),
                    text: $(`input[name='option_A']`).val(),
                };

                $.each(select, function(key, value){
                    $('select[name=correct_answer]').append($("<option></option>").attr("value", key.value).text(value.text));
                });
            }
        });
        $(`input[name='option_B']`).on('keyup', function(){
            if($(`input[name='option_B']`).val()) {
                $('select[name=correct_answer]').empty();
                select[1] = {
                    value: $(`input[name='option_B']`).val(),
                    text: $(`input[name='option_B']`).val(),
                };

                $.each(select, function(key, value){
                    $('select[name=correct_answer]').append($("<option></option>").attr("value", key.value).text(value.text));
                });
            }
        });

        $(`input[name='option_C']`).on('keyup', function(){
            if($(`input[name='option_C']`).val()) {
                $('select[name=correct_answer]').empty();
                select[2] = {
                    value: $(`input[name='option_C']`).val(),
                    text: $(`input[name='option_C']`).val(),
                };

                $.each(select, function(key, value){
                    $('select[name=correct_answer]').append($("<option></option>").attr("value", key.value).text(value.text));
                });
            }
        });

        $(`input[name='option_D']`).on('keyup', function(){
            if($(`input[name='option_D']`).val()) {
                $('select[name=correct_answer]').empty();
                select[3] = {
                    value: $(`input[name='option_D']`).val(),
                    text: $(`input[name='option_D']`).val(),
                };

                $.each(select, function(key, value){
                    $('select[name=correct_answer]').append($("<option></option>").attr("value", key.value).text(value.text));
                });
            }
        });

    </script>
@endpush