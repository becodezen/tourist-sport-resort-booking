@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Add new slider</h4>
                    </div>
                    <div class="action">
                        <a href="{{ route('slider.list') }}" class="btn btn-light">Slider list</a>
                    </div>
                </div>
                {!! Form::open(['route' => 'slider.store', 'method' => 'POST']) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                        <spant class="text-danger"></spant>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" rows="5" class="form-control"></textarea>
                        <spant class="text-danger"></spant>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="img-upload">
                                    <div class="img-prev">
                                        <div class="img-content">
                                            <img src="" alt="" id="imgPrev">
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
                                            <input type="file" name="image" id="imgInp">
                                            <span class="btn btn-danger btn-img-upload">Choose A Photo</span>
                                        </label>
                                    </div>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" onclick="formSubmit(this, event)" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection


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
            });

        }(jQuery))
    </script>
@endpush
