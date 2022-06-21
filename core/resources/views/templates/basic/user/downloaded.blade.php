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
                                    <th>@lang('Product')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($downloads as $key => $item)
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

                                            @if (!auth()->user()->existedRating($item->product->id))
                                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reviewModal" class="badge badge--primary px-2 py-2 reviewBtn" data-id="{{$item->product->id}}"><i class="las la-star-of-david" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Give Review')"></i></a>
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
                    {{$downloads->links()}}
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

    @if(count($downloads) > 0)
        <div class="modal fade cmn--modal" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('user.rating')}}" method="POST">
                        @csrf
                            <div class="modal-header">
                                <h5 class="m-0">@lang('Give Review')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="mb-2">@lang('Give your rating')</label><br>
                                        <div class='starrr' id='star{{ $key }}'></div><br>
                                        <input type='hidden' name='rating' value='0' id='star2_input'>
                                        <input type="hidden" name="product_id" value="">

                                        <label class="mt-2 mb-2">@lang('Write your opinion')</label><br>
                                        <textarea name="review" rows="5" class="form-control form--control" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('No')</button>
                                <button type="submit" class="cmn--btn btn--sm btn--success">@lang('Yes')</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection



@push('script-lib')
    <script src="{{asset($activeTemplateTrue.'js/starrr.js')}}"></script>
@endpush
@push('style')
<style>
  .form--control:focus {
        background: #0f1932;
        border-color: rgba(255, 255, 255, 0.1);
    }
    .starrr a {
        font-size: 44px;
        padding: 0 1px;
        cursor: pointer;
        color: #f9a60f;
        text-decoration: none;
    } 
</style>
@endpush
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

            $('.reviewBtn').on('click', function () {
                var modal = $('#reviewModal');
                modal.find('input[name=product_id]').val($(this).data('id'));

                var $s2input = $('input[name=rating]');
                var indx = @php echo $downloads->count() @endphp;
                var i = 0;
                for (i; i < indx; i++) {
                    $(`#star${i}`).starrr({
                        max: 5,
                        rating: $s2input.val(),
                        change: function(e, value){
                            $s2input.val(value).trigger('input');
                        }
                    });
                }
            });

        })(jQuery);
    </script>
@endpush
