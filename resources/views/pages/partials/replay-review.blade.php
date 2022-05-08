@php
    $replays = App\Models\Review::where('replay_review_id', $review->id)->where('replay', 1)->orderBy('id', 'ASC')->get();
@endphp

@if($replays->count() > 0)
    @foreach($replays as $review)
        <div class="ml-50 mt-20">
            <div class="review-head">
                <div class="user-area">
                    <div class="user-photo">
                        <img loading="eager|lazy" src="@if($review->user_id) {{ asset( user_image($review->user_id) ) }} @else {{ asset('demomedia/demoprofile.png') }} @endif" alt="">
                    </div>
                    <div class="user-meta">
                        @if($review->name == NULL)
                            <h4 class="username">No Name Reviewer</h4>
                        @else
                            <h4 class="username">{{$review->name}}</h4>
                        @endif

                        {{ review_rating($review->rating) }}
                    </div>
                </div>
                <div class="date-area">
                    <span class="date">
                        {{ $review->created_at->format('d M Y h:i A') }}
                    </span>
                </div>
            </div>
            <div class="review-body">
                <p>{!! $review->opinion !!}</p>
                {{ review_image($review->id) }}
            </div>
        </div>
    @endforeach
@endif
