<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h4 class="box-title">Add Category</h4>
        </div>
    </div>
    {!! Form::open(['route' => 'room.category.store', 'method' => 'POST']) !!}
    <div class="box-body">
        {{--@if($user_type === 'system_user')
            <div class="form-group">
                <label for="">Resort</label>
                {!! Form::select('resort', formSelectOptions($resorts), null, ['class' => 'form-control', 'placeholder' => 'Select Resort']) !!}
                <span class="text-danger"></span>
            </div>
        @elseif($user_type === 'resort_user')
            <input type="hidden" name="resort" value="{{ $resorts }}">
        @endif--}}
        <div class="form-group">
            <label for="room_type">Room Type</label>
            <input type="text" name="room_type" id="room_type" placeholder="E.G. AC" class="form-control">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="bed_size">Bed Size</label>
            <input type="text" name="bed_size" id="bed_size" placeholder="E.G. Single" class="form-control">
            <span class="text-danger"></span>
        </div>
    </div>
    <div class="box-footer">
        <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save</button>
    </div>
    {!! Form::close() !!}
</div>
