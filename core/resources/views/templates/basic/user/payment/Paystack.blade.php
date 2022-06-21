@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="container pt-80 pb-80">
        <div class="card custom--card card-deposit">
            <div class="card-header py-3 text-center">
                <h5 class="title"><span>@lang('Payment Preview')</span></h5>
            </div>
            <div class="card-body text-center">
                <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
            </div>
            <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center p-4">
                @csrf
                <h5>@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h5>
                <h5 class="my-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h5>
                <button type="button" class=" mt-4 cmn--btn" id="btn-confirm">@lang('Pay Now')</button>
                <script
                    src="//js.paystack.co/v1/inline.js"
                    data-key="{{ $data->key }}"
                    data-email="{{ $data->email }}"
                    data-amount="{{$data->amount}}"
                    data-currency="{{$data->currency}}"
                    data-ref="{{ $data->ref }}"
                    data-custom-button="btn-confirm"
                >
                </script>
            </form>
        </div>
    </div>
@endsection
