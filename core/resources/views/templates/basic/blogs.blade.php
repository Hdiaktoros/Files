@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="bg--section pt-80 pb-80">
        <div class="section--wrapper">

            @include($activeTemplate.'partials.leftbar')

            <div class="container wrapper-inner">
                @php echo advertisementOne('1188x80') @endphp

                <div class="row g-4 justify-content-center">
                    @foreach ($blogs as $item)
                        <div class="col-lg-4 col-md-6 col-sm-10">
                            <div class="post__item">
                                <div class="post__thumb">
                                    <a href="{{ route('blog.details',[slug(__(@$item->data_values->title)),$item->id]) }}">
                                        <img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'900x565') }}" alt="blog">
                                    </a>
                                    <span class="category">
                                        {{__(@$item->data_values->category)}}
                                    </span>
                                </div>
                                <div class="post__content">
                                    <h6 class="post__title">
                                        <a href="{{ route('blog.details',[slug(__(@$item->data_values->title)),$item->id]) }}">{{str_limit(__(@$item->data_values->title),60)}}</a>
                                    </h6>
                                    <div class="meta__date">
                                        <div class="meta__item">
                                            <i class="las la-calendar"></i>
                                            {{showDateTime(@$item->created_at,'d F, Y')}}
                                        </div>
                                        <div class="meta__item">
                                            <i class="las la-user"></i>
                                            @lang('Admin')
                                        </div>
                                    </div>
                                    <a href="{{ route('blog.details',[slug(__(@$item->data_values->title)),$item->id]) }}" class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{$blogs->links()}}

                @php echo advertisementTwo('3033x375') @endphp
            </div>

            @include($activeTemplate.'partials.rightbar')

        </div>
    </section>
@endsection
