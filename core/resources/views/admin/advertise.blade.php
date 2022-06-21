@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Add Size')</th>
                                <th scope="col">@lang('Impression')</th>
                                <th scope="col">@lang('Click')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @forelse ($adds as $item)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                    <td data-label="@lang('Ad Size')">
                                        {{$item->add_size}}
                                    <td data-label="@lang('Impression')">{{ $item->impression }}</td>
                                    <td data-label="@lang('Click')">{{ $item->click }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Disabled')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')"><a href="#" class="icon-btn  updateBtn" data-route="{{ route('admin.advertise.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" data-image="{{ getImage(imagePath()['advertise']['path'].'/'. $item->image,$item->add_size)}}"><i class="la la-pencil-alt"></i></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ $adds->links('admin.partials.paginate') }}
            </div>
        </div>
    </div>
</div>

{{-- Add METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add New Advertise')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.advertise.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Add Size')</label>
                        <select name="add_size" class="form-control" required>
                            <option value="" selected>@lang('Select One')</option>
                            <option value="3033x375">@lang('3033x375')</option>
                            <option value="1188x80">@lang('1188x80')</option>
                            <option value="540x776">@lang('540x776')</option>
                            <option value="540x984">@lang('540x984')</option>
                            <option value="300x250">@lang('300x250')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('Redirect Url')</label>
                        <input type="url"class="form-control" placeholder="@lang('Example') : https://www.demo.com/" name="url" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status">
                    </div>
                    <div class="form-group">
                        <b>@lang('Advertise Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" style="background-image: url({{ getImage('/') }})">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg, .gif" required>
                                    <label for="profilePicUpload1" class="bg--success"> @lang('Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Update METHOD MODAL --}}
<div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Payment Accept')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Add Size')</label>
                        <input type="text" class="form-control add-size" disabled>
                    </div>
                    <div class="form-group">
                        <label>@lang('Redirect Url')</label>
                        <input type="url" class="form-control url" placeholder="@lang('Example') : https://www.demo.com/" name="url" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label font-weight-bold">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status">
                    </div>
                    <div class="form-group">
                        <b>@lang('Advertise Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview update-image-preview">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg, .gif">
                                    <label for="profilePicUpload2" class="bg--success"> @lang('Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
@endsection

@push('script')
<script>
    $('.addBtn').on('click', function () {
        var modal = $('#addModal');
        modal.modal('show');
    });

    $('.updateBtn').on('click', function () {
            var modal = $('#updateBtn');
            var resourse = $(this).data('resourse');
            var route = $(this).data('route');

            $('.url').val(resourse.url);
            $('.add-size').val(resourse.add_size);

            if(resourse.status == 0){
                modal.find('.toggle').addClass('btn--danger off').removeClass('btn--success');
                modal.find('input[name="status"]').prop('checked',false);
            }else{
                modal.find('.toggle').removeClass('btn--danger off').addClass('btn--success');
                modal.find('input[name="status"]').prop('checked',true);
            }
            $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});

            $('select[name=add_size]').val(resourse.add_size);
            $('.edit-route').attr('action',route);
        });
</script>
@endpush
