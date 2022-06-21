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
                    <div >
                        <div class="d-flex flex-wrap justify-content-between mb-3 align-items-center">

                            <h5 class="d-title m-0">{{ __($pageTitle) }}</h5>
                            <a href="{{route('user.deposit')}}" class="cmn--btn btn--sm">@lang('Deposit Now')</a>
                        </div>
                        <table class="table cmn--table">
                            <thead>
                                <tr>
                                    <th>@lang('Transaction ID')</th>
                                    <th>@lang('Gateway')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Time')</th>
                                    <th> @lang('MORE')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($logs) >0)
                                    @foreach($logs as $k=>$data)
                                        <tr>
                                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                            <td data-label="@lang('Gateway')">{{ __(@$data->gateway->name)  }}</td>
                                            <td data-label="@lang('Amount')">
                                                <span class="text--success">{{showAmount($data->amount)}} {{__($general->cur_text)}}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    @if($data->status == 1)
                                                        <span class="badge badge--primary">@lang('Complete')</span>
                                                    @elseif($data->status == 2)
                                                        <span class="badge badge--warning">@lang('Pending')</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge badge--danger">@lang('Cancel')</span>
                                                    @endif

                                                    @if($data->admin_feedback != null)
                                                        <a href="#0" class="badge badge--info detailBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="fa fa-info"></i></a>
                                                    @endif
                                                </div>

                                            </td>
                                            <td data-label="@lang('Time')">
                                                <div>
                                                <i class="lar la-calendar-check"></i> {{showDateTime($data->created_at)}}
                                                </div>
                                            </td>

                                            @php
                                                $details = ($data->detail != null) ? json_encode($data->detail) : null;
                                            @endphp

                                            <td data-label="@lang('Details')">
                                                <a href="javascript:void(0)" class="badge badge--primary approveBtn px-2 py-2"
                                                   data-info="{{ $details }}"
                                                   data-id="{{ $data->id }}"
                                                   data-amount="{{ showAmount($data->amount)}} {{ __($general->cur_text) }}"
                                                   data-charge="{{ showAmount($data->charge)}} {{ __($general->cur_text) }}"
                                                   data-after_charge="{{ showAmount($data->amount + $data->charge)}} {{ __($general->cur_text) }}"
                                                   data-rate="{{ showAmount($data->rate)}} {{ __($data->method_currency) }}"
                                                   data-payable="{{ showAmount($data->final_amo)}} {{ __($data->method_currency) }}">
                                                    <i class="fa fa-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{$logs->links()}}
                </div>
            </div>
        </div>
    </section>

    {{-- APPROVE MODAL --}}
    <div class="modal fade cmn--modal" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item bg--section">@lang('Amount') : <span class="withdraw-amount "></span></li>
                        <li class="list-group-item bg--section">@lang('Charge') : <span class="withdraw-charge "></span></li>
                        <li class="list-group-item bg--section">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                        <li class="list-group-item bg--section">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li>
                        <li class="list-group-item bg--section">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                    </ul>
                    <ul class="list-group withdraw-detail mt-1">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
        <div class="modal fade cmn--modal" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-rate').text($(this).data('rate'));
                modal.find('.withdraw-payable').text($(this).data('payable'));
                var list = [];
                var details =  Object.entries($(this).data('info'));

                var ImgPath = "{{asset(imagePath()['verify']['deposit']['path'])}}/";
                var singleInfo = '';
                for (var i = 0; i < details.length; i++) {
                    if (details[i][1].type == 'file') {
                        singleInfo += `<li class="list-group-item bg--section">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="@lang('Image')" class="w-100">
                                        </li>`;
                    }else{
                        singleInfo += `<li class="list-group-item bg--section">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (singleInfo)
                {
                    modal.find('.withdraw-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${singleInfo}`);
                }else{
                    modal.find('.withdraw-detail').html(`${singleInfo}`);
                }
                modal.modal('show');
            });

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

