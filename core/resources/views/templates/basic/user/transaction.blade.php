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
                    <div>
                        <h5 class="d-title">{{__($pageTitle)}}</h5>
                        <table class="table cmn--table">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('Trx Type')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $item)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            <span>{{showDateTime($item->created_at,'Y-m-d')}}</span>
                                        </td>
                                        <td data-label="@lang('Amount')">
                                            @if ($item->trx_type == '+')
                                                <span class="text--success">{{$general->cur_sym}}{{showAmount($item->amount)}}</span>
                                            @elseif($item->trx_type == '-')
                                                <span class="text--danger">{{$general->cur_sym}}{{showAmount($item->amount)}}</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Charge')">
                                            <span>{{$general->cur_sym}} {{showAmount($item->charge)}}</span>
                                        </td>
                                        <td data-label="@lang('Balance')">
                                            <span>{{showAmount($item->post_balance)}}</span>
                                        </td>
                                        <td data-label="@lang('Trx Type')">
                                            @if ($item->trx_type == '+')
                                                <span class="text--success">{{$item->trx_type}}</span>
                                            @elseif($item->trx_type == '-')
                                                <span class="text--danger">{{$item->trx_type}}</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Details')">
                                            <span>{{$item->details}}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    </section>

@endsection
