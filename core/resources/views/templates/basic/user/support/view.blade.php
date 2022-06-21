@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container pt-80 pb-80">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card custom--card">
                    <div class="card-header d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <h5 class="card-title m-0">
                            @if($my_ticket->status == 0)
                                <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge badge--rimary py-2 px-3">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge badge--white text--dark py-2 px-3">@lang('Closed')</span>
                            @endif
                            [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                        </h5>
                        <button class="cmn--btn btn--danger close-button" type="button" title="@lang('Close Ticket')" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        @if($my_ticket->status != 4)
                            <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="replayTicket" value="1">
                                <div class="row justify-content-between">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control form--control bg--section p-4" id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="file-upload mt-4">
                                    <label class="form--label" for="inputAttachments">@lang('Attachments')</label>
                                    <div class="d-flex mb-4">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control bg--section" />
                                        <button type="button" class="cmn--btn btn--sm btn--primary addFile ms-3 border-0">
                                            <i class="fa fa-plus ms-0"></i>
                                        </button>
                                        <button type="submit" class="cmn--btn ms-3">
                                            <i class="fa fa-reply ms-0"></i> @lang('Reply')
                                        </button>
                                    </div>

                                    <div id="fileUploadsContainer"></div>
                                    <p class="ticket-attachments-message text-muted mt-3">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>
                            </form>
                        @endif
                        <div class="card custom--card mt-4 h-auto border-0">
                            <div class="card-body p-0">
                                @foreach($messages as $message)
                                    @if($message->admin_id == 0)
                                        <div class="row border-1 rounded my-2 py-3 mx-2 align-items-center">
                                            <div class="col-md-3 border-right text-right">
                                                <h6 class="ms-3 m-0">{{ $message->ticket->name }}</h6>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="py-3">
                                                    <p class="text-muted font-weight-bold mb-3">
                                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                    <p>{{$message->message}}</p>
                                                    @if($message->attachments()->count() > 0)
                                                        <div class="mt-2">
                                                            @foreach($message->attachments as $k=> $image)
                                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row border-1 rounded my-2 py-3 mx-2 bg--section ms-md-5 align-items-center">
                                            <div class="col-md-3 border-right text-right">
                                                <h6 class="ms-3 m-0">{{ $message->admin->name }}</h6>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="py-3">
                                                    <p class="text-muted font-weight-bold mb-3">
                                                        @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                    <p>{{$message->message}}</p>
                                                    @if($message->attachments()->count() > 0)
                                                        <div class="mt-2">
                                                            @foreach($message->attachments as $k=> $image)
                                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade cmn--modal" id="DelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn--btn btn--sm btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="cmn--btn btn--sm btn--success btn-sm"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group">
                        <input type="file" name="attachments[]" class="form-control my-3" required />
                        <div class="input-group-append support-input-group">
                            <span class="input-group-text btn btn-danger support-btn remove-btn">x</span>
                        </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
