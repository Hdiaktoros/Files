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
                    <div class="row justify-content-center g-4">
                        <div class="col-sm-6 col-lg-4">
                            <div class="dashboard-item">
                                <span class="dashboard-icon">
                                    <i class="far fa-money-bill-alt"></i>
                                </span>
                                <div class="cont">
                                    <div class="dashboard-header">
                                        <h2 class="title">{{showAmount($balance)}} {{$general->cur_text}}</h2>
                                    </div>
                                    <a href="#0">@lang('Balance')</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="dashboard-item">
                                <span class="dashboard-icon">
                                    <i class="fas fa-download"></i>
                                </span>
                                <div class="cont">
                                    <div class="dashboard-header">
                                        <h2 class="title">{{$totalDownloads}}</h2>
                                    </div>
                                    <a href="#0">@lang('Downloads')</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="dashboard-item">
                                <span class="dashboard-icon">
                                    <i class="fas fa-comments-dollar"></i>
                                </span>
                                <div class="cont">
                                    <div class="dashboard-header">
                                        <h2 class="title">{{$totalTransactions}}</h2>
                                    </div>
                                    <a href="#0">@lang('Transaction')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="pt-80">
                        <h5 class="d-title">Latest Download</h5>
                        <table class="table cmn--table">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Product')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestDownloads as $key => $item)
                                    <tr>
                                        <td data-label="@lang('Date')">
                                            <span>{{showDateTime($item->created_at,'Y-m-d')}}</span>
                                        </td>
                                        <td data-label="@lang('Product')">
                                            <span>{{str_limit(__($item->product->name),20)}}</span>
                                        </td>
                                        <td data-label="@lang('Price')">
                                            @if ($item->price)
                                                <span class="text--success">{{$item->price}} {{$item->currency}}</span>
                                            @else
                                                <span class="text--success">@lang('Free')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            @if ($item->product->file)
                                                <a href="{{route('user.product.download',Crypt::encrypt($item->product->id))}}" class="badge badge--primary px-2 py-2"><i class="fas fa-download"></i></a>
                                            @elseif ($item->product->link)
                                                <a href="javascript:void(0)" class="badge badge--primary px-2 py-2 downloadBtn" data-link="{{$item->product->link}}"><i class="fas fa-download"></i></a>
                                            @endif
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
                    <!-- Table -->
                </div>
            </div>
        </div>
    </section>

    {{-- Info MODAL --}}
    <div class="modal fade cmn--modal" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Download Link')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.downloadBtn').on('click', function() {
                var modal = $('#infoModal');
                var link = $(this).data('link');

                modal.find('.info').html(`<p><a href="${link}">${link}</a></p>`);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
