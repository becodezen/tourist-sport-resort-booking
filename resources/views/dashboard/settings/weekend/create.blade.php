<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h4 class="box-title">Add Weekend</h4>
        </div>
    </div>
    {!! Form::open(['route' => 'weekend.store', 'method' => 'POST']) !!}
    <div class="box-body">
        <div class="form-group">
            <label for="name">Name</label>
            {!! Form::select('name', getDaysList(), null, ['class' => 'form-control', 'placeholder' => 'Select weekend day']) !!}
            <span class="text-danger"></span>
        </div>
    </div>
    <div class="box-footer">
        <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save</button>
    </div>
    {!! Form::close() !!}
</div>
