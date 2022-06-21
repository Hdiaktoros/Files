@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="container pt-80 pb-80">
        <div class="card custom--card card-deposit">
            <div class="card-header py-3 text-center">
                <h5 class="title"><span>@lang('Payment Preview')</span></h5>
            </div>
            <div class="card-body">
                <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
            </div>
            <div class="p-4">
                <form action="{{$data->url}}" method="{{$data->method}}">
                    <h5 class="text-center">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h5>
                    <h5 class="my-3 text-center">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h5>
                    <script src="{{$data->src}}"
                        class="stripe-button"
                        @foreach($data->val as $key=> $value)
                        data-{{$key}}="{{$value}}"
                        @endforeach
                    >
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("cmn--btn w-100");
            $('button[type="submit"] span').addClass("cmn--btn h--50px stripe--btn");
        })(jQuery);
    </script>
@endpush
