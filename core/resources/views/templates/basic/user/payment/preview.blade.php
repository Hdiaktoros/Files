@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container pt-80 pb-80">
        <div class="row  justify-content-center">
            <div class="col-md-8">
                <div class="card card-deposit custom--card text-center">
                    <div class="card-body card-body-deposit">
                        <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="@lang('Image')" class="w-100" />
                        <ul class="list-group text-center">
                            <li class="list-group-item">
                                @lang('Amount'):
                                <span class="text--info">{{showAmount($data->amount)}} </span> {{__($general->cur_text)}}
                            </li>
                            <li class="list-group-item">
                                @lang('Charge'):
                                <span class="text--danger">{{showAmount($data->charge)}}</span> {{__($general->cur_text)}}
                            </li>
                            <li class="list-group-item">
                                @lang('Payable'): <span class="text--primary"> {{showAmount($data->amount + $data->charge)}}</span> {{__($general->cur_text)}}
                            </li>
                            <li class="list-group-item">
                                @lang('Conversion Rate'): <span class="text--warning">1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</span>
                            </li>
                            <li class="list-group-item">
                                @lang('In') {{$data->baseCurrency()}}:
                                <span class="text--base">{{showAmount($data->final_amo)}}</span>
                            </li>


                            @if($data->gateway->crypto==1)
                                <li class="list-group-item">
                                    @lang('Conversion with')
                                    <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer">
                        @if( 1000 >$data->method_code)
                            <a href="{{route('user.deposit.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                        @else
                            <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


