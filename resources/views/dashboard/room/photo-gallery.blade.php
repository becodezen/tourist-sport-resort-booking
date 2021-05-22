@extends('layouts.master')

@section('content')
    <div id="addGallery" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Photo To The Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['room.photo.store', $room->id], 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-md-8 offset-2">
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
                                            <input type="file" name="photo" id="imgInp">
                                            <span class="btn btn-danger btn-img-upload">Choose A Photo</span>
                                        </label>
                                    </div>
                                </div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Caption</label>
                        <input type="text" name="caption" placeholder="Caption" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="thumbnail">
                            <span>Set as thumbnail in front page</span>
                        </label>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Upload</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Photo Galleries: {{ $room->name }}</h4>
            </div>
            <div class="action">
                <button class="btn btn-sm btn-light" data-toggle="modal" data-target="#addGallery"><i class="fas fa-image"></i> Photo</button>
                <a href="{{ route('room.list') }}" class="btn btn-primary">Room List</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                @if($room->galleries->isNotEmpty())
                    @foreach($room->galleries as $gallery)
                        <div class="col-lg-3">
                            <div class="photo">
                                <img src="{{ asset($gallery->image) }}" alt="{{ $gallery->caption }}">
                                @if($gallery->caption)
                                    <h3 class="caption">{{ $gallery->caption }}</h3>
                                @endif
                                <div class="photo-action">
                                    {!! Form::open(['route' => ['room.photo.delete',['id' => $gallery->room_id, 'photo_id' => $gallery->id]], 'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12">
                        <p>No Photo Added Yet.</p>
                    </div>
                @endif
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
