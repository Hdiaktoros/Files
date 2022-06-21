@extends($activeTemplate.'layouts.frontend')

@section('content')

@php
    $contactContent = getContent('contact_us.content',true);
    $contactElements = getContent('contact_us.element',false);
@endphp

    <section class="contact-section pt-80 pb-80 bg--section">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="contact-contact">
                        <div class="section__header">
                            <h3 class="section__title mb-3">{{__(@$contactContent->data_values->title)}}</h3>
                            <p>
                                {{__(@$contactContent->data_values->short_details)}}
                            </p>
                        </div>
                        <div class="maps"></div>
                    </div>
                </div>
                <div class="col-lg-6 ps-xl-5">
                    <div class="account__wrapper bg--body">
                        <form class="account-form row g-4" method="POST" action="">
                            @csrf
                            <div class="col-md-6">
                                <label for="fname" class="form--label">@lang('Your Name')</label>
                                <input type="text" name="name" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @endif required>
                            </div>
                            <div class="col-md-6">
                                <label for="lname" class="form--label">@lang('Subject')</label>
                                <input type="text" name="subject"  class="form-control form--control" value="{{old('subject')}}" required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form--label">@lang('Email Address')</label>
                                <input type="email" name="email" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" @if(auth()->user()) readonly @endif required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form--label">@lang('Your Message')</label>
                                <textarea class="form-control form--control" name="message">{{old('message')}}</textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="cmn--btn btn--lg">@lang('Send Message')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="contact-info-section pb-80 bg--section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach($contactElements as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="contact__item bg--body h-100">
                        <div class="contact__item-icon">
                            @php echo @$item->data_values->icon @endphp
                        </div>
                        <h5 class="title">{{__(@$item->data_values->title)}}</h5>

                        <ul>
                            <li>
                                <a href="javascript:void(0)">{{__(@$item->data_values->details)}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="https://maps.google.com/maps/api/js?key={{@$contactContent->data_values->map_key}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/map.js')}}"></script>
@endpush

@push('script')

    <script>

        var mapOptions = {
            center: new google.maps.LatLng({{@$contactContent->data_values->latitude}}, {{@$contactContent->data_values->longitude}}),
            zoom: 10,
            styles: styleArray,
            scrollwheel: false,
            backgroundColor: '#e5ecff',
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
            mapOptions);
          var myLatlng = new google.maps.LatLng({{@$contactContent->data_values->latitude}}, {{@$contactContent->data_values->longitude}});
          var focusplace = {lat: {{@$contactContent->data_values->latitude}}, lng: {{@$contactContent->data_values->longitude}}};
          var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: {
                url: "{{asset($activeTemplateTrue.'images/map-marker.png')}}"
            }
          });
    </script>
@endpush
