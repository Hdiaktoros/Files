@extends($activeTemplate .'layouts.frontend')
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

                    <h6 class="text-center mt-2 mb-4">@lang('2FA Verification')</h6>
                    <p class="text-center">@lang('Current Time'): {{\Carbon\Carbon::now()}}</p>

                    <form class="account-form row g-4" action="{{route('user.go2fa.verify')}}" method="POST">
                        @csrf

                        <div class="col-md-12">
                            <label class="form--label">@lang('Verification Code')</label>
                            <input type="text" name="code" id="code" class="form-control form--control" required>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="cmn--btn btn--lg">@lang('Submit')</button>
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
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;

              $(this).val(function (index, value) {
                 value = value.substr(0,7);
                  return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
              });

      });

      $('.front-header, .front-footer').addClass('d-none');
    })(jQuery)
</script>
@endpush
