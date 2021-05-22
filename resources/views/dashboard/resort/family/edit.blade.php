@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-9">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">{{ $page_title }}</h4>
                    </div>
                    <div class="action">
                        <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                    </div>
                </div>
                {!! Form::open(['route' => ['resort.user.update',[ 'resort_id' => $resort->id, 'id' => $family->id]], 'method' => 'PUT']) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" value="{{ $family->name }}" class="form-control" placeholder="Enter name">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $family->email }}" placeholder="Enter email" readonly>
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Phone <small class="text-info">(will be username as user)</small></label>
                                <input type="text" name="phone" value="{{ $family->phone }}" class="form-control" placeholder="Enter phone" readonly>
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="">User Type</label>
                                {!! Form::select('user_type', [
                                    'admin' => 'Resort Owner',
                                    'manager' => 'Resort Manager'
                                ], $user_type, ['placeholder' => 'Select User Type', 'class' => 'form-control']) !!}
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="img-upload">
                                    <div class="img-prev">
                                        <div class="img-content">
                                            <img src="{{ asset($family->photo) }}" alt="" id="imgPrev">
                                            <span id="close"><i class="fas fa-times"></i></span>
                                            <span id="img-name"></span>
                                        </div>
                                        <div class="img-prev-bg">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span>No photo chosen yet</span>
                                        </div>
                                    </div>
                                    <div class="input-file">
                                        <label class="text-center">
                                            <input type="file" name="photo" id="imgInp">
                                            <span class="btn btn-danger btn-img-upload">Choose Photo</span>
                                        </label>
                                    </div>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save</button>
                </div>
                {!! Form::close() !!}
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
