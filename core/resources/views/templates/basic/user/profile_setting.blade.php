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
                    <form class="profile-area bg--body" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="user-profile">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}" alt="user">
                                    </div>
                                    <div class="content">
                                        <h5 class="title">{{$user->fullname}}</h5>
                                        <span>@lang('Username'): {{$user->username}}</span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="remove-image cmn--btn btn--sm btn--danger w-100 justify-content-center text-center mb-3">
                                            <i class="las la-times"></i>
                                        </div>
                                        <label for="profile-image" class="show-image cmn--btn btn--primary w-100 justify-content-center text-center">@lang('Change Profile Photo')</label>
                                        <input class="form-control form--control" type="file" name="image" accept="image/*"  id="profile-image" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="user-profile-form row mb--20">
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('First Name')</label>
                                        <input class="form-control form--control" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('Last Name')</label>
                                        <input class="form-control form--control" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" required>
                                    </div>
                                    <div class="col-md-12 mb-20">
                                        <label class="form--label">@lang('Email Address')</label>
                                        <input class="form-control form--control" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('Mobile Number')</label>
                                        <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('Address')</label>
                                        <input class="form-control form--control" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('State')</label>
                                        <input class="form-control form--control" name="state" placeholder="@lang('State')" value="{{@$user->address->state}}" required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('Zip Code')</label>
                                        <input class="form-control form--control" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('City')</label>
                                        <input class="form-control form--control" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label class="form--label">@lang('Country')</label>
                                        <input class="form-control form--control" value="{{@$user->address->country}}" disabled>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="cmn--btn btn--base w-unset">@lang('Update Profile')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    "use strict"
    var prevImg = $('.user-profile .thumb').html();
    function proPicURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = $('.user-profile').find('.thumb');
                preview.html(`<img src="${e.target.result}" alt="user">`);
                preview.addClass('has-image');
                preview.hide();
                preview.fadeIn(650);
                $(".remove-image").show();
                $(".show-image").hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-image").on('change', function() {
        proPicURL(this);
    });
    $(".remove-image").on('click', function(){
        $(".user-profile .thumb").html(prevImg);
        $(".user-profile .thumb").removeClass('has-image');
        $(this).hide();
        $(".show-image").show();
    })
</script>
@endpush
