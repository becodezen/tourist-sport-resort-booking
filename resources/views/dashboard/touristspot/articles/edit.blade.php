@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Update Article : {{ $article->name }}</h4>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.article.list', $article->tourist_spot_id) }}" class="btn btn-dark">Article list</a>
            </div>
        </div>
        {!! Form::open(['route' => ['tourist.spot.article.update', ['tourist_spot_id' => $article->tourist_spot_id, 'id' => $article->id]], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="">Article Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter article title" value="{{ $article->title }}">
                <span class="text-danger"></span>
            </div>
            <div class="form-group mb-25">
                <label for="">Content</label>
                <textarea name="description" class="form-control summernote">{!! $article->description !!}</textarea>
                <span class="text-danger"></span>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <div class="img-upload">
                            <div class="img-prev">
                                <div class="img-content">
                                    <img src="{{ asset($article->thumbnail) }}" alt="" id="imgPrev">
                                    <span id="close"><i class="fas fa-times"></i></span>
                                    <span id="img-name"></span>
                                </div>
                                <div class="img-prev-bg">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>No file chosen yet</span>
                                </div>
                            </div>
                            <div class="input-file">
                                <label class="text-center">
                                    <input type="file" name="thumbnail" id="imgInp">
                                    <span class="btn btn-danger btn-img-upload">Update Thumbnail</span>
                                </label>
                            </div>
                        </div>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save Changes</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection

@push('plugin-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
@endpush

@push('plugin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            //image preview functions
            function imagePrev(i, img)
            {
                if (i.files && i.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(img).attr('src', e.target.result);

                        if ($(img).siblings('#close').length > 0) {
                            $(img).siblings('#close').css({
                                opacity: 1
                            });
                        }

                        if ($(img).siblings('#img-name').length > 0) {
                            $(img).siblings('#img-name').html(i.files[0].name).css({
                                opacity: 1
                            });
                        }
                    }

                    reader.readAsDataURL(i.files[0]);
                }
            }

            jQuery(document).ready(function() {
                //image preview
                $(document).on('change', '#imgInp', function () {
                    imagePrev(this, '#imgPrev');
                });

                $(document).on('click', '#close', function () {
                    $('#imgInp').val('');
                    $(this).css({
                        opacity: 0
                    }).siblings('#imgPrev').attr('src', '');
                    $('#img-name').html('').css({
                        opacity: 0
                    });
                });

                if ($('.summernote').length > 0) {
                    $(".summernote").summernote({
                        minHeight: 200,
                        maxHeight: null,
                        focus: !1,
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['fontsize', ['fontsize']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ],
                        placeholder: 'Write Content ...........'
                    });
                }

            });

        }(jQuery))
    </script>
@endpush
