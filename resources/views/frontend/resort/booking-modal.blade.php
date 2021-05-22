<div id="bookModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking Information</h5>
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body has-inside-modal">
                <div class="inside-modal" id="insideModal">
                    <div class="inside-modal-content">
                        <div class="otp-box">
                            <div class="otp-box-header">
                                <h5>Verify Phone</h5>
                                <span  class="close-inside-modal">
                                    <span aria-hidden="true">&times;</span>
                                </span>
                            </div>
                            <div class="otp-box-body">
                                <p class="mb-10">We have sent a code to: <strong id="otpPhone">01798673163</strong></p>
                                <div class="form-group mt-30">
                                    <label for="otp">Enter you code here: <span class="test_otp"></span></label>
                                    <input type="text" id="otp" class="form-control" autocomplete="off">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="otp-box-footer">
                                <button type="button" id="otpConfirmBtn" class="btn btn-sm btn-info mb-15">Confirm</button>
                                <p>Didn't received any code?</p>
                                    <div class="code-resend">
                    {{--                    <span id="countDown">00:59</span>--}}
                                        <a href="#">Resend  Code</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end inside modal -->

                <h5 class="modal-section-title">Room Information</h5>
                <div class="row">
                    <div class="col-md-8">
                        <table class="table room-info" id="roomList">

                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table room-info">
                            <tr>
                                <td>Check In</td>
                                <td id="room_info_check_in" class="text-right"></td>
                            </tr>
                            <tr>
                                <td>Check Out</td>
                                <td id="room_info_check_out" class="text-right"></td>
                            </tr>
                            <tr>
                                <td>Sub total</td>
                                <td  class="text-right"><input type="text" name="sub_total" class="text-right" id="sub_total" placeholder="0.00" readonly></td>
                            </tr>
                            <tr>
                                <td>Grand total</td>
                                <td  class="text-right"><input type="text" name="grand_total" class="text-right" id="grand_total" placeholder="0.00" readonly></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h5 class="modal-section-title">Guest Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Name</label>
                            <div class="form-input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" placeholder="Enter name" id="guestName" class="form-control" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->name : '' }}">
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Phone</label>
                            @if(Auth::guard('customer')->user())
                            <div class="form-input-group">
                                <i class="fas fa-phone"></i>
                                <input type="text" name="phone" autocomplete="off" id="guestPhone" class="form-control" placeholder="phone" value="{{ Auth::guard('customer')->user()->phone }}">
                            </div>
                            @else
                            <div class="phone-verify">
                                <div class="form-input-group">
                                    <i class="fas fa-phone"></i>
                                    <input type="text" name="phone" autocomplete="off" id="guestPhone" class="form-control" placeholder="phone">
                                </div>
                                <button type="button" id="verifyPhone" class="btn btn-sm btn-success">Verify</button>
                            </div>
                            @endif
                            <span class="text-danger"></span>
                        </div>
                        @if(!Auth::guard('customer')->user())
                            <label>
                                <input type="checkbox" value="1" name="is_user" id="isUser">
                                <span>Registration as User?</span>
                            </label>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <div class="form-input-group">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="email" id="guestEmail" class="form-control" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->email : '' }}">
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <div class="form-input-group">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="address" placeholder="address" id="guestAddress" class="form-control" @if(Auth::user()) value="{{ Auth::user()->profile ? Auth::user()->profile->address : '' }}" @endif>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </div>

                @if(!Auth::guard('customer')->user())
                <div class="row" id="registerAsUser">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Password</label>
                            <div class="form-input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" class="form-control" placeholder="*******">
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <div class="form-input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="*******">
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <button class="btn btn-primary" id="guestBookingSubmit" type="submit" onclick="bookingSubmit(this, event)" {{ Auth::guard()->user() ? '' : 'disabled' }}>Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>
