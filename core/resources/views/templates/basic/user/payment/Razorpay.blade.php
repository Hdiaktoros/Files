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
                <h5 class="text-center">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h5>
                <h5 class="my-3 text-center">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h5>
                <form action="{{$data->url}}" method="{{$data->method}}">
                    <input type="hidden" custom="{{$data->custom}}" name="hidden">
                    <script src="{{$data->checkout_js}}"
                            @foreach($data->val as $key=>$value)
                            data-{{$key}}="{{$value}}"
                        @endforeach >
                    </script>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("cmn--btn w-100 justify-content-center");
        })(jQuery);
    </script>
@endpush
