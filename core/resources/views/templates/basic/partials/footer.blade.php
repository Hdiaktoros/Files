@php
    $footerContent = getContent('footer.content',true);
    $footerElements = getContent('footer.element',false);
@endphp

<!-- Footer Section -->
<footer class="front-footer">
    <div class="footter-top @if(request()->routeIs('home')) bg--section @endif">
        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4">
                    <div class="footer__widget footer__widget-about">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img alt="logo">
                            </a>
                        </div>
                        <p class="addr">
                            {{__(@$footerContent->data_values->short_details)}}
                        </p>
                        <ul class="social__icons">
                            @foreach ($footerElements as $item)
                                <li>
                                    <a href="{{@$item->data_values->url}}">@php echo @$item->data_values->social_icon @endphp</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4 gy-5 pl-xl-5">
                        <div class="col-sm-4 col-6">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Shortcut Link')</h5>
                                <ul class="footer__links">
                                    <li>
                                        <a href="{{route('home')}}">@lang('Home')</a>
                                    </li>
                                    <li>
                                        <a href="{{route('products')}}">@lang('Products')</a>
                                    </li>
                                    <li>
                                        <a href="{{route('blogs')}}">@lang('Blog')</a>
                                    </li>
                                    <li>
                                        <a href="{{route('contact')}}">@lang('Contact')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Company Policy')</h5>
                                <ul class="footer__links">
                                    @foreach ($policyElements as $item)
                                        <li>
                                            <a href="{{route('policy',$item->id)}}">{{__(@$item->data_values->title)}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="footer__widget">
                                <h5 class="widget--title">@lang('Categories')</h5>
                                <ul class="footer__links">
                                    @foreach ($categories->take(4) as $item)
                                        <li>
                                            <a href="{{route('category.search',[slug($item->name),$item->id])}}">{{__($item->name)}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom @if(request()->routeIs('home')) bg--body @else bg--section @endif  text-center">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="left">
                    @lang('All Right Reserved by') <a href="{{route('home')}}" class="text--base">{{ $general->sitename }}</a>
                </div>
                <div class="right">
                    <img src="{{ getImage('assets/images/frontend/footer/'.@$footerContent->data_values->payment_image,'250x30') }}" alt="footer">
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section -->
