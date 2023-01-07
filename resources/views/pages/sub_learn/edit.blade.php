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
                            @if ($data->pdf_url)
                                <div class="mt-2">
                                    <a href="{{$data->pdf_url}}" target="_blank" rel="noopener noreferrer">Link File PDF</a>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="link_youtube">Link Youtube</label>
                            <input class="form-control @error('link_youtube') is-invalid @enderror" value="{{$data->link_youtube}}" name="link_youtube" id="link_youtube" type="text" placeholder="Input link youtube">
                            @if($errors->has('link_youtube'))
                                <div class="invalid-feedback">{{ $errors->first('link_youtube') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="video">Video</label>
                            <input class="form-control @error('video') is-invalid @enderror" name="video" id="video" type="file" accept=".mp4,.MP4,.webm,.WEBM,.avi,.AVI" placeholder="Input video">
                            @if($errors->has('video'))
                                <div class="invalid-feedback">{{ $errors->first('video') }}</div>
                            @endif
                            @if ($data->video_url)
                                <div class="mt-2">
                                    <a href="{{$data->video_url}}" target="_blank" rel="noopener noreferrer">Link Video</a>
                                </div>
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

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"> <span class="value-progress">0</span></div>
                        </div>

                        <div>
                            <h6 class="mb-3">Upload Images</h6>
                            <div class='repeater'>
                                <div data-repeater-list="soal_images">
                                    @if (isset($data->images))
                                        @foreach ($data->images as $index => $soal_image)
                                        <div data-repeater-item class="form-group">
                                            <div class="d-flex">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="{{"soal_images[$index][id]"}}" value="{{$data->images[$index]['id']}}" class="form-control" id="inputid">
                                                        <input type="file" name="{{"soal_images[$index][image]"}}" class="custom-file-input" id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose image</label>
                                                    </div>
                                                </div>
                                                <input data-repeater-delete class="btn btn-outline-danger btn-sm ml-lg-2 ml-1" type="button" value="Delete" />
                                            </div>
                                        </div>
                                        @if ($data->images[$index]['image'])
                                            <div class="mb-3 mt-n2">
                                                <a href="{{$data->getSoalImageUrlAttribute($data->images[$index]['image'])}}" target="_blank" rel="noopener noreferrer">Link Image {{$index +1}}</a>
                                            </div>
                                        @endif
                                        @endforeach
                                    @else
                                    <div data-repeater-item class="form-group">
                                        <div class="d-flex">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose image</label>
                                                </div>
                                            </div>
                                            <input data-repeater-delete class="btn btn-outline-danger btn-sm ml-lg-2 ml-1" type="button" value="Delete" />
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <input data-repeater-create class="btn btn-success btn-sm" type="button" value="Add Image" />
                            </div>
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

@push('scripts')
  <script>
    $('.progress').hide();

    var value_progess = $('.value-progress');
    var progess_bar = $('.progress-bar');

    $('button[type="submit"]').on('click', function(e) {
        $('.progress').show();

        value_progess.html('50%')
        progess_bar.css('width', '50%');
    });

    $(document).ready(function () {
        $('.repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
                $('input[name="image_id"]').each(function(){
                    console.log($(this).val())
                });
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this image?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function (setIndexes) {
                // console.log(setIndexes)
            },
            isFirstItemUndeletable: true
        })
    });

  </script>
@endpush
