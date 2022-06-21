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
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Categogry')</th>
                                    <th scope="col">@lang('Type')</th>
                                    <th scope="col">@lang('File/Link')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Download')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($products as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Image')">
                                            <div class="user justify-content-center">
                                                    <div class="thumb"><img src="{{ getImage(imagePath()['product']['path'].'/thumb_'. $item->image,imagePath()['product']['thumb'])}}" alt="@lang('image')"></div>
                                            </div>
                                        </td>
                                        <td data-label="@lang('Name')">{{ $item->name }}</td>
                                        <td data-label="@lang('Name')">{{ $item->category->name }}</td>
                                        <td data-label="@lang('Type')">
                                            @if ($item->type == 0)
                                                <span class="badge badge--warning">@lang('Free')</span>
                                            @elseif ($item->type == 1)
                                                <span class="badge badge--primary">@lang('Paid')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('File/Link')">
                                            @if ($item->file)
                                                <span class="badge badge--success">@lang('File')</span>
                                            @elseif ($item->link)
                                                <span class="badge badge--primary">@lang('Link')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Price')">
                                            @if ($item->price)
                                                {{showAmount($item->price)}}
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td data-label="@lang('Download')">{{$item->download}}</td>
                                        <td data-label="@lang('Status')">
                                            @if ($item->status == 0)
                                                <span class="badge badge--danger">@lang('Deactive')</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge badge--primary">@lang('Active')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">

                                            <a href="{{route('admin.product.edit',$item->id)}}" class="icon-btn"><i class="la la-pencil-alt"></i></a>

                                        </td>
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
                    {{ $products->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>



    @push('breadcrumb-plugins')
        <a href="{{route('admin.product.new')}}" class="btn btn--primary mr-3 mt-2"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>


        @if(request()->routeIs('admin.product.index'))
            <form action="{{ route('admin.product.search') }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Product Name')" value="{{ request()->search??null }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('admin.product.search') }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
                <div class="input-group has_append">
                    <input type="text" name="search" class="form-control" placeholder="@lang('Product Name')" value="{{ request()->search??null }}">
                    <div class="input-group-append">
                        <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        @endif

    @endpush
@endsection
