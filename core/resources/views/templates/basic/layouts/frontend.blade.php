<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>

    @include('partials.seo')

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <!-- site color -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php?color1='.$general->base_color)}}">
    @stack('style-lib')

    @stack('style')
</head>
<body>

@stack('fbComment')

<div id="version" class="dark-version">
    <div class="overlay"></div>

    @include($activeTemplate.'partials.header')
    @yield('content')
    @include($activeTemplate.'partials.footer')
</div>


@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp

@if(@$cookie->data_values->status && !session('cookie_accepted'))
    <div class="cookie-remove">
        <div class="cookie__wrapper">
            <div class="container">
                <p class="txt my-2 w-100">
                    @php echo @$cookie->data_values->description @endphp
                    <a href="{{ @$cookie->data_values->link }}" target="_blank" class=" mt-2">@lang('Read Policy')</a>
                    <button class="cmn--btn my-2 ms-3 policy btn--sm cookie">@lang('Accept')</button>
                </p>
            </div>
        </div>
    </div>
@endif


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/nice-select.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('partials.notify')


<script>
    (function ($) {
        "use strict";

        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        $('.cookie').on('click',function () {

            var url = "{{ route('cookie.accept') }}";

            $.get(url,function(response){

                if(response.success){
                notify('success',response.success);
                $('.cookie-remove').html('');
                }
            });

        });

        $('.clickUp').on('click',function () {

            var id = $(this).data('id');

            var url = "{{ route('add.clickup') }}";
            var data = {id:id};

            $.get(url, data,function(response){

                if(response.id){
                    $.each(response.id, function (i, val) {
                        notify('error',val);
                    });
                }
            });

        });


        @if($general->theme == 1)
            localStorage.setItem('light_version', true);
            $('#version').addClass('light-version');
            $('.logo img').attr('src', "{{ getImage(imagePath()['logoIcon']['path'] .'/logo_light.png') }}");
        @else
            localStorage.removeItem('light_version');
            $('#version').removeClass('light-version');
            $('.logo img').attr('src', "{{ getImage(imagePath()['logoIcon']['path'] .'/logo_dark.png') }}");
        @endif


    })(jQuery);
</script>

</body>
</html>
