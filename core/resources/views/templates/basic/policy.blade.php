@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="pt-80 pb-80 bg--section">
    <div class="section--wrapper">
        @include($activeTemplate.'partials.leftbar')

        <div class="container wrapper-inner">
            @php echo advertisementOne('1188x80') @endphp

            <div class="row gy-5">
                <div class="col-lg-12">
                    <div class="product__details">
                        <div class="product__details-content">
                            <div class="d-flex flex-wrap justify-content-between align-items-center title-area">
                                <div class="title-side">
                                    <h5 class="product__details-title">{{__(@$policy->data_values->title)}}</h5>
                                </div>
                            </div>

                            <div class="product-description txt">
                                @php echo @$policy->data_values->description_nic @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php echo advertisementTwo('3033x375') @endphp
        </div>

        @include($activeTemplate.'partials.rightbar')
    </div>
</section>
@endsection
