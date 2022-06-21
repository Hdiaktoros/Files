@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="pt-80 pb-80 bg--section">
    <div class="section--wrapper">
        @include($activeTemplate.'partials.leftbar')

        <div class="container wrapper-inner">
            @php echo advertisementOne('1188x80') @endphp

            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="product__details">
                        <div class="product__details-thumb">
                            <img src="{{ getImage(imagePath()['product']['path'].'/'. $product->image,imagePath()['product']['size'])}}" alt="products">
                        </div>
                        <div class="product__details-content">
                            <div class="d-flex flex-wrap justify-content-between align-items-center title-area">
                                <div class="title-side">
                                    <h5 class="product__details-title">{{__($product->name)}}</h5>
                                    <div class="meta">
                                        <span class="info">@lang('Category') : {{__($product->category->name)}}</span>
                                        <span class="info">@lang('Subategory') : {{__($product->subcategory->name)}}</span>
                                        @if ($product->type == 0 && $product->price == null)
                                            <span class="info">@lang('Free')</span>
                                        @endif

                                        @if ($product->type == 1 && $product->price)
                                            <span class="info">{{$general->cur_sym}}{{showAmount($product->price,2)}}</span>
                                        @endif

                                        <span class="info"><i class="las la-download"></i>({{$product->download}})</span>
                                        <span class="info d-inline-flex">
                                            <span class="ratings">{{$product->avg_rating}} <i class="las la-star"></i></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="btn-side">
                                    @auth
                                        <a href="javascript:void(0)" class="cmn--btn btn--sm infoBtn" data-price="{{$product->price}}">@lang('Download')</a>
                                    @else
                                        <a href="{{route('user.login')}}" class="cmn--btn btn--sm">@lang('Sign in to download')</a>
                                    @endauth
                                </div>
                            </div>

                            <div class="product-description txt">
                                @php echo $product->description @endphp
                            </div>

                            <div class="d-flex flex-wrap align-items-center">
                                <h6 class="share-title my-2 me-4">@lang('Share Now')</h6>
                                <ul class="social__icons">
                                    <li>
                                        <a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug($product->name)}}" target="_blank" title="@lang('Facebook')"><i class="lab la-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug($product->name)}}" target="_blank" title="@lang('Twitter')"><i class="lab la-pinterest-p"></i></a>
                                    </li>
                                    <li>
                                        <a href="http://twitter.com/share?text={{slug($product->name)}}&url={{urlencode(url()->current()) }}" target="_blank" title="@lang('Twitter')"><i class="lab la-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug($product->name)}}" target="_blank" title="@lang('Linkedin')"><i class="lab la-linkedin-in"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav--tabs border-0">
                            <li class="nav-item">
                                <a href="#description" data-bs-toggle="tab" class="nav-link active">
                                    @lang('Description')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#review" data-bs-toggle="tab" class="nav-link">
                                    @lang('Review')
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="description">
                                <div class="table-wrapper bg--body">
                                    <table class="specification-table">
                                        <tbody>
                                        <tr>
                                            <th>@lang('Total Download')</th>
                                            <td><span class="text--base"><i class="las la-download"></i> ({{$product->download}})</span></td>
                                        </tr>

                                        @if($product->info)
                                            @foreach($product->info as $info)
                                                <tr>
                                                    <th>{{__($info->title)}}</th>
                                                    <td>{{__($info->detail)}}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody></table>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="review">
                                <div class="review-area bg--body comment-list">
                                    @forelse($ratings as $item)
                                        <div class="review-item">
                                            <div class="thumb">
                                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $item->user->image,imagePath()['profile']['user']['size']) }}" alt="review">
                                            </div>
                                            <div class="content">
                                                <div class="entry-meta">
                                                    <h6 class="posted-on">
                                                        <a href="javascript:void(0)">{{__($item->user->fullname)}}</a>
                                                        <span>@lang('Posted on') {{showDateTime($item->created_at,'F d, Y')}} @lang('at') {{showDateTime($item->created_at,'h:i A')}}</span>
                                                    </h6>
                                                    <div class="ratings">
                                                        @php echo displayRating($item->rating) @endphp
                                                    </div>
                                                </div>
                                                <div class="entry-content">
                                                    <p>{{__($item->review)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="review-item">
                                            <div class="content">
                                                <div class="entry-meta">
                                                    <h6 class="posted-on">
                                                        <span>@lang('No review found yet')</span>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>

                                @if (count($ratings) > 5)
                                    <div class="text-center">
                                        <button class="cmn--btn mt-4" type="button" id="loadMoreBtn">@lang('Load More')</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar__widget">
                        <h5 class="title">@lang('More Products')</h5>
                        <div class="row g-2 g-sm-3">
                            @foreach($moreProducts as $item)
                                <div class="col-6 col-md-4 col-lg-12 col-xl-6">
                                    <a href="{{ route('product.details',[slug(__($item->name)),$item->id]) }}" class="product__item">
                                        <img src="{{ getImage(imagePath()['product']['path'].'/thumb_'. $item->image,imagePath()['product']['thumb'])}}" alt="product">
                                        <span class="download-count">
                                            <i class="las la-download"></i>
                                            <span>({{$item->download}})</span>
                                        </span>
                                        <div class="product__item-content">
                                            <h6 class="product__item-title">{{str_limit(__($item->name),17)}}</h6>
                                            <div class="d-flex justify-content-between">
                                                <div class="ratings">
                                                    @php echo displayRating($item->avg_rating) @endphp
                                                </div>
                                                @if ($item->type == 0 && $item->price == null)
                                                    <span class="price">@lang('Free')</span>
                                                @endif

                                                @if ($item->type == 1 && $item->price)
                                                    <span class="price">{{$general->cur_sym}} {{showAmount($item->price)}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @php echo advertisementTwo('3033x375') @endphp
        </div>

        @include($activeTemplate.'partials.rightbar')
    </div>
</section>

{{-- Info MODAL --}}
<div class="modal fade cmn--modal" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('user.order')}}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Information')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="cmn--btn btn--sm btn--success">@lang('Yes')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection




@push('shareImage')
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ __($product->name) }}">
    <meta itemprop="description" content="{{ strip_tags(__($product->description)) }}">
    <meta itemprop="image" content="{{ getImage(imagePath()['product']['path'].'/thumb_'. $product->image,imagePath()['product']['thumb'])}}">

    <!-- Facebook Meta Tags -->
    <meta property="og:image" content="{{ getImage(imagePath()['product']['path'].'/thumb_'. $product->image,imagePath()['product']['thumb'])}}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __($product->name) }}">
    <meta property="og:description" content="{{ strip_tags(__($product->description)) }}">
    <meta property="og:image:type" content="{{ getImage(imagePath()['product']['path'].'/thumb_'. $product->image,imagePath()['product']['thumb'])}}" />
    @php $social_image_size = explode('x', imagePath()['product']['thumb']) @endphp
    <meta property="og:image:width" content="{{ $social_image_size[0] }}" />
    <meta property="og:image:height" content="{{ $social_image_size[1] }}" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.infoBtn').on('click', function() {
                var modal = $('#infoModal');
                var price = $(this).data('price');
                var message;

                if (price) {
                    message = parseFloat(price).toFixed(2) + " {{__($general->cur_text)}} @lang('will be subtracted from your balance. Are you sure to download this product ?')";
                }else{
                    message = "@lang('Are you sure to download this product ?')";
                }

                modal.find('.info').html(`<p> ${message} </p>`);
                modal.modal('show');
            });


            var counter = 5;

            $('#loadMoreBtn').on('click', function() {
                $.ajax({
                    type: "get",
                    url: "{{ route('loadmore.rating') }}",
                    data:{count:counter,id:'{{$product->id}}'},
                    dataType: "json",
                    success: function (response) {

                        if (response.ratings.length < 5) {
                            $('#loadMoreBtn').remove();
                        }

                        if(response.html){
                            $('.comment-list').append(response.html);
                        }

                        counter = parseInt(counter) + parseInt(5);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

