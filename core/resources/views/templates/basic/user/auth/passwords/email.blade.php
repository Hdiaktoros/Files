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

                    <h6 class="text-center mt-2 mb-4">@lang('Reset Password')</h6>

                    <form class="account-form row g-4" action="{{ route('user.password.email') }}" method="POST">
                        @csrf

                        <div class="col-md-12">
                            <label class="form--label">@lang('Select One')</label>
                            <div class="select-item-2">

                                <select name="type" class="select-bar w-100">
                                    <option value="email">@lang('E-Mail Address')</option>
                                    <option value="username">@lang('Username')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form--label my_value"></label>
                            <input type="text" name="value" value="{{ old('value') }}" class="form-control form--control @error('value') is-invalid @enderror" required>

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="cmn--btn btn--lg">@lang('Send Reset Code')</button>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between">
                                <a href="{{route('user.login')}}" class="text--base">@lang('Back to Login') ?</a>
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

    (function($){
        "use strict";

        myVal();
        $('select[name=type]').on('change',function(){
            myVal();
        });
        function myVal(){
            $('.my_value').text($('select[name=type] :selected').text());
        }

        $('.front-header, .front-footer').addClass('d-none');
    })(jQuery)
</script>
@endpush
