@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="container pt-80 pb-80">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="dashboard-menu-open d-xl-none">
                    <i class="las la-ellipsis-v"></i>
                </div>
                <div class="card custom--card">
                    <div class="card-header d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <h5 class="d-title m-0">{{ __($pageTitle) }}</h5>
                        <a href="{{route('ticket')}}" class="cmn--btn btn--sm">@lang('My Support Ticket')</a>
                    </div>
                    <div class="card-body">
                        <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row g-4">
                                <div class="form-group col-md-6">
                                    <label class="form--label" for="name">@lang('Name')</label>
                                    <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form--control bg--section" placeholder="@lang('Enter your name')" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form--label" for="email">@lang('Email address')</label>
                                    <input type="email"  name="email" value="{{@$user->email}}" class="form-control form--control bg--section" placeholder="@lang('Enter your email')" readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form--label" for="website">@lang('Subject')</label>
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form-control form--control bg--section" placeholder="@lang('Subject')" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form--label" for="priority">@lang('Priority')</label>
                                    <select name="priority" class="form-control form--control bg--section">
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="form--label" for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form-control form--control bg--section">{{old('message')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <div class="file-upload">
                                    <label class="form--label" for="inputAttachments">@lang('Attachments')</label>
                                    <div class="d-flex mb-4">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control bg--section" />
                                        <button type="button" class="cmn--btn btn--sm btn--primary addFile ms-3 border-0">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                    <div id="fileUploadsContainer"></div>
                                    <p class="ticket-attachments-message text-muted mt-4">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>
                            </div>

                            <div class="row form-group justify-content-center">
                                <div class="col-md-12">
                                    <button class="cmn--btn btn--sm mt-4" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group mb-2">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text cmn--btn btn--danger remove-btn" type="button"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
