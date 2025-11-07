@extends('frontend.layout.master')
@section('title','Blog | E-Shopper')

@section('menu_left')
@include('frontend.layout.menu_left')
@endsection

@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Latest From our Blog</h2>

    @foreach($posts as $item)
    <div class="single-blog-post">
        <h3>{{ $item->title }}</h3>
        <div class="post-meta">
            <ul>
                <li><i class="fa fa-user"></i> {{ $item->author ?? 'Admin' }}</li>
                <li><i class="fa fa-clock-o"></i> {{ $item->created_at->format('H:i') }}</li>
                <li><i class="fa fa-calendar"></i> {{ $item->created_at->format('M d, Y') }}</li>
            </ul>
            @php
            $avg = round($item->avg_rate ?? 0, 1);
            $full = floor($avg);
            $half = ($avg - $full) >= 0.5 ? 1 : 0;
            $empty = 5 - $full - $half;
            @endphp
            <span>
                @for($i = 0; $i < $full; $i++)
                    <i class="fa fa-star"></i>
                    @endfor

                    @if($half)
                    <i class="fa fa-star-half-o"></i>
                    @endif

                    @for($i = 0; $i < $empty; $i++)
                        <i class="fa fa-star-o"></i>
                        @endfor

                        <small>({{ $avg }})</small>
            </span>
        </div>

        <a href="{{ route('blog.show', [$item->id, $item->slug_or_title_slug]) }}">
            <img src="{{ asset('upload/blog/'.$item->image) }}" alt="{{ $item->title }}" class="blog-img">

        </a>

        <p>{{ $item->description ?? \Illuminate\Support\Str::limit(strip_tags($item->description), 150) }}</p>
        <p>{{ \Illuminate\Support\Str::of(html_entity_decode($item->content ?? ''))->stripTags()->limit(120) }}</p>

        <a class="btn btn-primary"
            href="{{ route('blog.show', [$item->id, $item->slug_or_title_slug]) }}">Read More</a>
    </div>
    @endforeach

    <div class="pagination-area">
        {!! $posts->links('pagination::bootstrap-4') !!}
    </div>

</div>
@endsection