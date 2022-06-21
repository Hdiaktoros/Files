<div class="col-xl-3">
    <div class="dashboard-menu">
        <div class="user">
            <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
            <div class="thumb">
                <a href="{{ route('user.profile.setting') }}">
                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="user">
                </a>
            </div>
            <div class="content">
                <h6 class="title"><a href="{{ route('user.profile.setting') }}">{{auth()->user()->fullname}}</a></h6>
            </div>
        </div>

        <ul>
            <li>
                <a href="{{route('user.home')}}" class="{{menuActive('user.home')}}"><i class="las la-home"></i>@lang('Dashboard')</a>
            </li>
            <li>
                <a href="{{ route('user.profile.setting') }}" class="{{menuActive('user.profile.setting')}}"><i class="las la-user-circle"></i>@lang('Profile')</a>
            </li>
            <li>
                <a href="{{ route('user.change.password') }}" class="{{menuActive('user.change.password')}}"><i class="las la-key"></i>@lang('Change Passoword')</a>
            </li>
            <li>
                <a href="{{ route('user.twofactor') }}" class="{{menuActive('user.twofactor')}}"><i class="las la-shield-alt"></i>@lang('2FA Security')</a>
            </li>
            <li>
                <a href="{{route('user.deposit.history')}}" class="{{menuActive('user.deposit*')}}"><i class="las la-money-check-alt"></i>@lang('Deposit')</a>
            </li>
            <li>
                <a href="{{route('ticket')}}" class="{{menuActive('ticket')}}"><i class="las la-ticket-alt"></i>@lang('Ticket')</a>
            </li>
            <li>
                <a href="{{route('user.downloads')}}" class="{{menuActive('user.downloads')}}"><i class="las la-download"></i>@lang('Downloads')</a>
            </li>
            <li>
                <a href="{{route('user.transactions')}}" class="{{menuActive('user.transactions')}}"><i class="las la-exchange-alt"></i>@lang('Transaction Log')</a>
            </li>
            <li>
                <a href="{{ route('user.logout') }}"><i class="las la-power-off"></i>@lang('Logout')</a>
            </li>
        </ul>
    </div>
</div>
