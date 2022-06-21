@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80 bg--section">
        <div class="section--wrapper">
            @include($activeTemplate.'partials.leftbar')

            <div class="wrapper-inner container">
                @php echo advertisementOne('1188x80') @endphp

                <div class="section__header">
                    <h4 class="section__title">@lang('Our Products')</h4>
                    <ul class="header-links">
                        <li>
                            <a href="{{route('products')}}" class="active">@lang('View All')</a>
                        </li>
                    </ul>
                </div>

                <div class="row g-2 g-sm-3">
                    @foreach ($products as $item)
                        <div class="col-xl-3 col-md-4 col-6 p-custom-width">
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

                @php echo advertisementTwo('3033x375') @endphp
            </div>

            @include($activeTemplate.'partials.rightbar')
        </div>
    </section>

    <section class="pt-80 pb-80">
        <div class="section--wrapper">
            @include($activeTemplate.'partials.leftbar')

            <div class="wrapper-inner container">
                @php echo advertisementOne('1188x80') @endphp

                <div class="section__header">
                    <h4 class="section__title">@lang('Top Rated')</h4>

                </div>
                <div class="row g-2 g-sm-3">
                    @foreach ($topRatedProducts as $item)
                        <div class="col-xl-3 col-md-4 col-6 p-custom-width">
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

                @php echo advertisementTwo('3033x375') @endphp

            </div>

            @include($activeTemplate.'partials.rightbar')
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
