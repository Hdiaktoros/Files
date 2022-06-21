@extends($activeTemplate.'layouts.frontend')
@section('content')

<div class="account-section pt-70 pb-70">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-lg-8">
                <div class="account__wrapper bg--section">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img alt="logo">
                        </a>
                    </div>

                    <h5 class="text-center mt-2 mb-4">@lang('Reset Password')</h5>

                    <form class="account-form row g-4" method="POST" action="{{ route('user.password.update') }}">
                        @csrf

                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="col-md-12 hover-input-popup">
                            <label class="form--label">@lang('Password')</label>
                            <input type="password" name="password" id="password" class="form-control form--control  @error('password') is-invalid @enderror" required>

                            @if($general->secure_password)
                                <div class="input-popup">
                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                    <p class="error number">@lang('1 number minimum')</p>
                                    <p class="error special">@lang('1 special character minimum')</p>
                                    <p class="error minimum">@lang('6 character password')</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label class="form--label">@lang('Confirm Password')</label>
                            <input id="password-confirm" type="password" name="password_confirmation" class="form-control form--control" required>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="cmn--btn btn--lg">@lang('Reset Password')</button>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between">

                                <a href="{{ route('user.login') }}" >@lang('Login Here')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";

        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif

        $('.front-header, .front-footer').addClass('d-none');
    })(jQuery);
</script>
@endpush
