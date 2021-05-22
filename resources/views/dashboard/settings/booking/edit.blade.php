<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h4 class="box-title">Booking Setting</h4>
        </div>
    </div>
    {!! Form::open(['route' => ['setting.booking.update'], 'method' => 'PUT']) !!}
    <div class="box-body">
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="weekend_price" value="1" id="weekend_price" {{ $settings->is_weekend_price ? 'checked' : '' }}>
                <label for="weekend_price" class="custom-control-label">Active Weekend Price on Booking.</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="holiday_price" value="1" id="holiday_price"  {{ $settings->is_holiday_price ? 'checked' : '' }}>
                <label for="holiday_price" class="custom-control-label">Active Holiday Price on Booking.</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="is_vat" value="1" id="is_vat" {{ $settings->is_vat_active ? 'checked' : '' }}>
                <label for="is_vat" class="custom-control-label">VAT active on Booking</label>
            </div>
        </div>
        <div id="vat">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vat Amount %(in Percentage)</label>
                        <input type="text" name="vat_amount" placeholder="Vat amount" id="vat_amount" class="form-control" value="{{ $settings->vat }} " disabled>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Vat type</label>
                        {!! Form::select('vat_type', [
    'inclusive' => 'Inclusive',
    'exclusive' => 'Exclusive',
], $settings->vat_type, ['class' => 'form-control', 'disabled', 'id' => 'vat_type', 'placeholder' => 'Select  vat type']) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer text-right">
        <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save Changes</button>
    </div>
    {!! Form::close() !!}
</div>

@push('footer-scripts')
    <script>
        (function($) {
            "use-strict"

            jQuery(document).ready(function(){

                if ($('#is_vat').is(':checked')) {
                    $('#vat_amount, #vat_type').prop('disabled', false);
                }

                $(document).on('change', '#is_vat', function(){
                    if ($(this).is(':checked')) {
                        $('#vat_amount, #vat_type').prop('disabled', false);
                    } else {
                        $('#vat_amount, #vat_type').prop('disabled', true);
                        $('#vat_amount').val('');
                        $('#vat_type').val('');
                    }
                })

            });

        }(jQuery))
    </script>
@endpush
