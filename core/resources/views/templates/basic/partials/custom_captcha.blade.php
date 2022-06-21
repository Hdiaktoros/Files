@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
    <div class="col-md-12">
        @php echo $captcha @endphp
    </div>
    <div class="col-md-12">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control" required>
    </div>
@endif
