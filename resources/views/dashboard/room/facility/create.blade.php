<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h4 class="box-title">Add Facility</h4>
        </div>
    </div>
    {!! Form::open(['route' => 'room.facility.store', 'method' => 'POST']) !!}
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
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Facility name" class="form-control">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" id="description" rows="2"  placeholder="Description name" class="form-control"></textarea>
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="name">Facility Type</label>
            {!! Form::select('facility_type', getFacilityType(), null, ['placeholder' => 'Select Facility Type', 'class' => "form-control"]) !!}
            <span class="text-danger"></span>
        </div>
    </div>
    <div class="box-footer">
        <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save</button>
    </div>
    {!! Form::close() !!}
</div>
