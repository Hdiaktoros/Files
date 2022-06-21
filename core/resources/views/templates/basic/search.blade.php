@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="pt-80 pb-80 bg--section">
        <div class="section--wrapper">
            @include($activeTemplate.'partials.leftbar')

            <div class="container wrapper-inner">
                <div class="filter-category-header">
                    <div class="fileter-select-item me-auto show-results">
                        <div>@lang('Showing') <span class="text--base">{{$products->count()}} of {{$products->total()}}</span></div>
                    </div>
                </div>
                <div class="row g-2 g-sm-3 mb-5">
                    @forelse ($products as $item)
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
                    @empty
                        <div class="col-xl-12 col-md-12 col-12 p-custom-width">
                            <p>{{__($emptyMessage)}}</p>
                        </div>
                    @endforelse

                    {{$products->links()}}

                </div>

                @php echo advertisementOne('1188x80') @endphp
            </div>

            @include($activeTemplate.'partials.rightbar')
        </div>
    </section>
@endsection
