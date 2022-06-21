@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="bg--section pt-80 pb-80">
        <div class="container">
            <div class="row">
                @include($activeTemplate.'user.leftbar')

                <div class="col-xl-9">
                    <div class="dashboard-menu-open d-xl-none">
                        <i class="las la-ellipsis-v"></i>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card custom--card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                </div>

                                @if(Auth::user()->ts)
                                    <div class="card-body">
                                        <div class="two-factor-content">
                                            <div class="text-center">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#disableModal" class="cmn--btn">@lang('Disable Two Factor Authenticator')</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="two-factor-content">
                                            <div class="input-group">
                                                <input type="text" name="key" value="{{$secret}}" class="form-control h--50px form--control bg--section" id="referralURL" readonly>
                                                <button class="input-group-text form--control copytext" type="button">
                                                    <i class="lar la-copy"></i>
                                                </button>
                                            </div>
                                            <div class="two-factor-scan text-center my-4">
                                                <img class="mw-100" src="{{$qrCodeUrl}}" alt="images">
                                            </div>
                                            <div class="text-center">
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#enableModal" class="cmn--btn">@lang('Enable Two Factor Authenticator')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card custom--card h-100">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Google Authenticator')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="two-factor-content">
                                        <h6 class="subtitle--bordered">@lang('Use Google Authenticator To Scan The QR Code Or Use The Code')</h6>
                                        <p class="two__fact__text">
                                            @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                        </p>
                                        <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank" class="cmn--btn">@lang('Download App')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade cmn--modal" id="enableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('user.twofactor.enable')}}" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="col-md-12">
                        <input type="hidden" name="key" value="{{$secret}}">
                        <input type="text" class="form-control form--control bg--section" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="cmn--btn btn--sm btn--success">@lang('Verify')</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade cmn--modal" id="disableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your Otp To Disable')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('user.twofactor.disable')}}" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="col-md-12">
                        <input type="hidden" name="key" value="{{$secret}}">
                        <input type="text" class="form-control form--control bg--section" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Verify')</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


