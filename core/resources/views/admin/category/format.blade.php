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
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($formats as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Action')">

                                            <a href="#" class="icon-btn updateBtn" data-route="{{ route('admin.category.format.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" ><i class="la la-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $formats->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New File Format')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.category.format.store',$subcategory->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('File Format Name') <code class="text-danger">(@lang('Only alpha numeric value'))</code></label>
                            <input type="text"class="form-control" id="input1" placeholder="@lang('Example : apk')" name="name" required>
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
                    <h5 class="modal-title"> @lang('Update File Format')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" class="edit-route" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('File Format Name') <code class="text-danger">(@lang('Only alpha numeric value'))</code></label>
                            <input type="text"class="form-control name" id="input2" placeholder="@lang('Example : apk')" name="name" required>
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
        <a href="javascript:window.history.back();" class="btn btn--primary mr-3 mt-2"><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
        <a href="javascript:void(0)" class="btn btn--primary mr-3 mt-2 addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>


        @if(request()->routeIs('admin.category.format'))
            <form action="{{ route('admin.category.format.search',$subcategory->id) }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('File Format Name')" value="{{ request()->search??null }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('admin.category.format.search',$subcategory->id) }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('File Format Name')" value="{{ request()->search??null }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @endif

    @endpush
@endsection

@push('script')
<script>
    'use strict';

    (function ($) {

        $('#input1').on('keypress', function(e) {

            var keyCode = e.keyCode || e.which;
            var regex = /^[A-Za-z0-9]+$/;

            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                alert('Only alpha numeric value');
                $('#input1').val('');
            }
        });

        $('#input2').on('keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            var regex = /^[A-Za-z0-9]+$/;

            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                alert('Only alpha numeric value');
                $('#input2').val('');
            }
        });

        $('.addBtn').on('click', function () {
            var modal = $('#addModal');
            modal.modal('show');
        });

        $('.updateBtn').on('click', function () {
            var modal = $('#updateBtn');

            var resourse = $(this).data('resourse');

            var route = $(this).data('route');
            $('.name').val(resourse.name);
            $('.edit-route').attr('action',route);

        });
    })(jQuery);
</script>
@endpush
