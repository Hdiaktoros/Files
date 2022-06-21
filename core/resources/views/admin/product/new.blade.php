@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="POST" action="{{route('admin.product.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>@lang('Product Image')</h5>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('',imagePath()['product']['size'])}})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" required>
                                                <label for="profilePicUpload1" class="bg--success"> @lang('Image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                                @lang('Image Will be resized to'): <b>{{imagePath()['product']['size']}}</b> @lang('px and thumb will be resized to'): <b>{{imagePath()['product']['thumb']}}</b>

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Product Name') <span class="text-danger">*</span></label>
                                            <input type="text"class="form-control" placeholder="@lang('Example : Adaware Antivirus')" value="{{ old('name') }}" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Type') <span class="text-danger">*</span></label>
                                            <select  name="type" class="form-control" id="type" required>
                                                <option value="0">@lang('Free')</option>
                                                <option value="1">@lang('Paid')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Category') <span class="text-danger">*</span></label>
                                            <select  name="category_id" id="category" class="form-control" required>

                                                @foreach ($categories as $item)
                                                    <option data-subcategory="{{$item->subcategories}}" value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Subcategory') <span class="text-danger">*</span></label>
                                            <select name="sub_category_id" id="subcategory" class="form-control" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Link/File') <span class="text-danger">*</span></label>
                                            <select  name="file_link" class="form-control" id="file-link" required>
                                                <option value="2">@lang('Link')</option>
                                                <option value="1">@lang('File')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="file-link-div">

                                    </div>

                                    <div class="col-md-12" id="price-div">

                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Status')</label>
                                            <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Disabled" name="status">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="payment-method-body mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border--primary">
                                        <h5 class="card-header bg--primary  text-white">@lang('Add Information')
                                            <button type="button" class="btn btn-sm btn-outline-light float-right addInformationData"><i class="la la-fw la-plus"></i>@lang('Add New')
                                            </button>
                                        </h5>

                                        <div class="card-body">
                                            <div class="row iData">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Description')</label>
                                            <textarea name="description" class="form-control nicEdit" rows="15"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('style')
    <style>
        .remove-information {
        position: absolute;
        top: 5px;
        right: 30px;
        text-align: center;
        width: 25px;
        height: 25px;
        font-size: 15px;
        border-radius: 50%;
        background-color: #df1c1c;
        color: #fff;
    }
    </style>
@endpush

@push('script')
    <script>
        "use strict";

        $('#category').on('change',function(){

            var subcategory = $(this).find('option:selected').data('subcategory');

            $('#subcategory').empty();

            $.each(subcategory, function (index, value) {
                if (value.status == 1) {
                    $('#subcategory').append(`<option value="${value.id}" data-formats='${JSON.stringify(value.formats)}'>${value.name}</option>`);
                }
            });

            var value = $('#file-link').find('option:selected').val();

            if (value == 1) {

                var formats = $('#subcategory').find('option:selected').data('formats');

                var formatString = '';
                var counter = formats.length;
                var acceptFormat = '';

                $.each(formats, function (i, v) {
                    counter --;
                    formatString += v.name;
                    acceptFormat += '.';
                    acceptFormat += v.name;

                    if(counter !=0 ){
                        formatString += ', ';
                        acceptFormat += ', ';
                    }
                });


                var html;
                html = `<div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Upload File') <span class="text-danger">*</span> <code>(@lang('Allowed file extexsion : ${formatString}'))</code></label>
                            <input type="file" class="form-control" name="file" accept="${acceptFormat}"  required>
                        </div>`;

                $('#file-link-div').html(html);
            }

        }).change();

        $('#file-link').on('change',function(){

            var value = $(this).find('option:selected').val();
            var formats = $('#subcategory').find('option:selected').data('formats');

            var formatString = '';
            var counter = formats.length;
            var acceptFormat = '';

            $.each(formats, function (i, v) {
                counter --;
                formatString += v.name;
                acceptFormat += '.';
                acceptFormat += v.name;

                if(counter !=0 ){
                    formatString += ', ';
                    acceptFormat += ', ';
                }
            });

            var html;

            if (value == 1) {
                html = `<div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Upload File') <span class="text-danger">*</span> <code>(@lang('Allowed file extexsion : ${formatString}'))</code></label>
                            <input type="file" class="form-control" name="file" accept="${acceptFormat}"  required>
                        </div>`;

                $('#file-link-div').html(html);
            }

            if (value == 2) {
                html = `<div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Link') <span class="text-danger">*</span></label>
                            <input type="url"class="form-control" placeholder="@lang('Example') : https://www.demo.com/" value="{{ old('link') }}" name="link" required>
                        </div>`;

                $('#file-link-div').html(html);
            }
        }).change();


        $('#subcategory').on('change',function(){

            var value = $('#file-link').find('option:selected').val();

            if (value == 1) {

                var formats = $(this).find('option:selected').data('formats');

                var formatString = '';
                var counter = formats.length;
                var acceptFormat = '';

                $.each(formats, function (i, v) {
                    counter --;
                    formatString += v.name;
                    acceptFormat += '.';
                    acceptFormat += v.name;

                    if(counter !=0 ){
                        formatString += ', ';
                        acceptFormat += ', ';
                    }
                });


                var html;
                html = `<div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Upload File') <span class="text-danger">*</span> <code>(@lang('Allowed file extexsion : ${formatString}'))</code></label>
                            <input type="file" class="form-control" name="file" accept="${acceptFormat}"  required>
                        </div>`;

                $('#file-link-div').html(html);
            }

        });

        $('#type').on('change',function(){
            var value = $(this).find('option:selected').val();

            if (value == 1) {
                var html = `<div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Product Price') <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ $general->cur_text }}</div>
                                    </div>
                                    <input type="number" step="any" class="form-control" placeholder="0" name="price" value="{{ old('price') }}" required/>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span
                                            class="currency_symbol">{{ $general->cur_sym }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                $('#price-div').html(html);
            }

            if (value == 0) {
                var html = ``;
                $('#price-div').html(html);
            }

        }).change();

        var idx = 0;
        $('.addInformationData').on('click', function() {

            var html =  `<div class="col-md-4 mb-4 i-data">
                            <div class="mr-2 ml-2" style="border: 1px solid black; border-radius: 5px;">
                                <button type="button" class="remove-information"><i class="fa fa-times"></i></button>
                                <div class="form-group mt-3">
                                    <label class="ml-3 mr-3">@lang('Title')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control ml-3 mr-3" name="info[${idx}][title]" placeholder="@lang('Example: Duration')" required>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="ml-3 mr-3">@lang('Details')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control ml-3 mr-3" name="info[${idx}][detail]" placeholder="@lang('Example: 171min 27s')" required>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        idx++;
            $('.iData').append(html);
        });

        $(document).on('click', '.remove-information', function() {
            $(this).parents('.i-data').remove();
        });

    </script>
@endpush
