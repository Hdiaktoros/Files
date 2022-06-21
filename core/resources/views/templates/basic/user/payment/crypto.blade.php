@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container pt-80 pb-80">
        <div class="card custom--card card-deposit">
            <div class="card-header py-3 text-center">
                <h5 class="title"><span>@lang('Payment Preview')</span></h5>
            </div>
            <div class="card-body card-body-deposit text-center">
                <h5 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h5>
                <h6 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h6>
                <img src="{{$data->img}}" alt="@lang('Image')">
                <h4 class="cmn--btn mt-4 mb-3">@lang('SCAN TO SEND')</h4>
            </div>
        </div>
    </div>

@endsection
