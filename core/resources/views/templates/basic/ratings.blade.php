@foreach($ratings as $item)
    <div class="review-item">
        <div class="thumb">
            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $item->user->image,imagePath()['profile']['user']['size']) }}" alt="review">
        </div>
        <div class="content">
            <div class="entry-meta">
                <h6 class="posted-on">
                    <a href="javascript:void(0)">{{__($item->user->fullname)}}</a>
                    <span>@lang('Posted on') {{showDateTime($item->created_at,'F d, Y')}} @lang('at') {{showDateTime($item->created_at,'h:i A')}}</span>
                </h6>
                <div class="ratings">
                    @php echo displayRating($item->rating) @endphp
                </div>
            </div>
            <div class="entry-content">
                <p>{{__($item->review)}}</p>
            </div>
        </div>
    </div>
@endforeach
