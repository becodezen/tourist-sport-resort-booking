@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Create Route Instruction : {{ $spot->name }}</h4>
            </div>
            <div class="action">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                <a href="{{ route('instruction.list', $spot->id) }}" class="btn btn-outline-primary">Route Instruction list</a>
            </div>
        </div>
        {!! Form::open(['route' => ['instruction.store', $spot->id], 'method' => 'POST']) !!}
        <div class="box-body">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter instruction title">
                <span class="text-danger"></span>
            </div>
            <div class="form-group mb-25">
                <label for="">Content</label>
                <textarea name="description" class="form-control summernote"></textarea>
                <span class="text-danger"></span>
            </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save Instruction</button>
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


            jQuery(document).ready(function() {

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
