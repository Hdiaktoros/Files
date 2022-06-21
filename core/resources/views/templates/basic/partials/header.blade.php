<!-- Header -->
<header class="front-header">
    <div class="header-top">
        <div class="container">
            <ul class="header-top-wrapper">
                <li class="me-auto">
                    <select id="language" class="select-bar langSel">
                        @foreach($language as $item)
                            <option value="{{ __($item->code) }}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                        @endforeach
                    </select>
                </li>
                @auth
                    <li>
                        <a href="{{ route('user.home') }}" class="header-btn">@lang('Dashboard')</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('user.register') }}">@lang('Sign Up')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.login') }}" class="header-btn">@lang('Sign In')</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img alt="logo">
                    </a>
                </div>
                <form class="search-form" method="GET" action="{{route('product.search')}}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="@lang('By product, category name')">
                        <button class="cmn--btn input-group-text" type="submit"><i class="las la-search"></i></button>
                    </div>
                </form>
                <ul class="menu">
                    @foreach ($categories as $key => $item)
                        @if($key < 6)
                            <li>
                                <a href="javascript:void(0)">{{__($item->name)}}</a>
                                @if (count($item->subcategories) > 0)
                                    <ul class="submenu">
                                        @foreach($item->subcategories as $data)
                                            <li>
                                                <a href="{{route('subcategory.search',[slug($data->name),$data->id])}}">{{__($data->name)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @else
                            <li>
                                <a href="javascript:void(0)">@lang('More')</a>
                                <ul class="mega__menu">
                                    <li>
                                        <ul class="d-flex flex-wrap mega-menu-wrapper">
                                            <li class="mega__menu-item">
                                                <h6 class="title">{{__($item->name)}}</h6>
                                                @if (count($item->subcategories) > 0)
                                                    <ul>
                                                        @foreach($item->subcategories as $data)
                                                            <li>
                                                                <a href="{{route('subcategory.search',[slug($data->name),$data->id])}}">{{__($data->name)}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="search-bar d-md-none ms-auto">
                    <i class="las la-search"></i>
                </div>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header -->
