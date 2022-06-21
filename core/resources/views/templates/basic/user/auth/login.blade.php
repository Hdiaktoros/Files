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
                        
                        <form class="account-form row g-4" action="{{ route('user.login')}}" method="POST" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="col-md-12">
                                <label class="form--label">@lang('Username or Email')</label>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control form--control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form--label">@lang('Password')</label>
                                <input type="password" name="password" id="password"  class="form-control form--control" required>
                            </div>
                            <div class="col-md-12 google-captcha">
                                @php echo loadReCaptcha() @endphp
                            </div>
                            @include($activeTemplate.'partials.custom_captcha')

                            <div class="col-md-12">
                                <button type="submit" class="cmn--btn btn--lg">@lang('Sign In')</button>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <a href="{{route('user.password.request')}}" class="text--base">@lang('Forgot Password') ?</a>
                                    <div>
                                        @lang('I do not have an account'). <a href="{{route('user.register')}}" class="text--base">@lang('Create Account')</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        $('.front-header, .front-footer').addClass('d-none');
    </script>
@endpush
