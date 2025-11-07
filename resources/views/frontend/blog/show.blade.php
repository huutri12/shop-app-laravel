@extends('frontend.layout.master')
@section('title', $post->title . ' | E-Shopper')

@section('menu_left')
@include('frontend.layout.menu_left')
@endsection

@section('content')
<div class="blog-post-area">
  <h2 class="title text-center">LATEST FROM OUR BLOG</h2>

  <div class="single-blog-post">
    <h3>{{ $post->title }}</h3>
    <div class="post-meta">
      <ul>
        <li><i class="fa fa-user"></i> {{ $post->author ?? 'Admin' }}</li>
        <li><i class="fa fa-clock-o"></i> {{ $post->created_at->format('H:i') }}</li>
        <li><i class="fa fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}</li>
      </ul>
    </div>

    <img src="{{ asset('upload/blog/'.$post->image) }}" alt="{{ $post->title }}" class="blog-img">

    <div class="mt-3 post-content">
      @if(!empty($post->content))
      {!! html_entity_decode($post->content) !!}
      @elseif(!empty($post->description))
      <p>{{ $post->description }}</p>
      @endif
    </div>

    <div class="rating-area mt-4">
      <ul class="ratings">
        <li class="rate-this">Rate this item:</li>
        <li>
          <div class="rate"
            id="rateBox"
            data-user-rate="{{ (int) ($userRate ?? 0) }}"
            data-post-id="{{ $post->id }}"
            data-rate-url="{{ route('blog.rate') }}">
            <div class="vote d-inline-block">
              <span class="star_1 ratings_stars"><input type="hidden" value="1"></span>
              <span class="star_2 ratings_stars"><input type="hidden" value="2"></span>
              <span class="star_3 ratings_stars"><input type="hidden" value="3"></span>
              <span class="star_4 ratings_stars"><input type="hidden" value="4"></span>
              <span class="star_5 ratings_stars"><input type="hidden" value="5"></span>
            </div>
          </div>
        </li>
        <li class="color">(<span id="avg-rate">{{ $avgRate }}</span> votes)</li>
      </ul>
    </div>

  </div>

  <div class="pagination-area mt-4">
    <ul class="pagination">
      @if($prev)
      <li><a href="{{ route('blog.show', [$prev->id, $prev->slug_or_title_slug]) }}">
          <i class="fa fa-angle-left"></i> Prev</a>
      </li>
      @endif

      <li><a href="{{ route('blog.index') }}">All</a></li>

      @if($next)
      <li><a href="{{ route('blog.show', [$next->id, $next->slug_or_title_slug]) }}">
          Next <i class="fa fa-angle-right"></i></a>
      </li>
      @endif
    </ul>
  </div>

  <div class="response-area mt-4">
    <h2>RESPONSES</h2>
    <ul class="media-list" id="comment-list">
      @foreach($comments as $cmt)
      <li class="media" data-id="{{ $cmt->id }}">
        <a class="pull-left" href="#">
          <img class="media-object" src="{{ $cmt->avatar_user ?? asset('images/blog/man-two.jpg') }}" alt="">
        </a>
        <div class="media-body">
          <ul class="sinlge-post-meta">
            <li><i class="fa fa-user"></i>{{ $cmt->name_user }}</li>
            <li><i class="fa fa-clock-o"></i> {{ $cmt->created_at->format('H:i') }}</li>
            <li><i class="fa fa-calendar"></i> {{ $cmt->created_at->format('M d, Y') }}</li>
          </ul>
          <p>{{ $cmt->content }}</p>
          <a class="btn btn-primary btn-reply" href="javascript:void(0)" data-parent="{{ $cmt->id }}"><i class="fa fa-reply"></i>Reply</a>

          @foreach($cmt->children as $child)
          <div class="media second-media mt-2" data-id="{{ $child->id }}">
            <a class="pull-left" href="#">
              <img class="media-object" src="{{ $child->avatar_user ?? asset('images/blog/man-three.jpg') }}" alt="">
            </a>
            <div class="media-body">
              <ul class="sinlge-post-meta">
                <li><i class="fa fa-user"></i>{{ $child->name_user }}</li>
                <li><i class="fa fa-clock-o"></i> {{ $child->created_at->format('H:i') }}</li>
                <li><i class="fa fa-calendar"></i> {{ $child->created_at->format('M d, Y') }}</li>
              </ul>
              <p>{{ $child->content }}</p>
            </div>
          </div>
          @endforeach

          <div class="children-box"></div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>


  <div class="replay-box mt-4">
    <h2>Leave a reply</h2>
    <form id="main-comment-form">
      @csrf
      <input type="hidden" name="id_blog" value="{{ $post->id }}">
      <div class="text-area">
        <div class="blank-arrow">
          <label>Your Comment</label>
        </div>
        <span>*</span>
        <textarea name="content" rows="5" required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Post comment</button>
      </div>
    </form>
  </div>


</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // 1. CSRF cho tất cả ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    /** RATING */
    const box = $('#rateBox');
    const myRate = parseInt(box.data('user-rate') || 0, 10);
    const postId = box.data('post-id');
    const rateUrl = box.data('rate-url');

    // tô sẵn sao nếu user đã vote
    if (myRate > 0) {
      $('.ratings_stars').each(function() {
        const v = parseInt($(this).find('input').val(), 10);
        if (v <= myRate) $(this).addClass('ratings_over');
      });
    }
    $('.ratings_stars').hover(
      // Handles the mouseover
      function() {
        $(this).prevAll().andSelf().addClass('ratings_hover');
        // $(this).nextAll().removeClass('ratings_vote'); 
      },
      function() {
        $(this).prevAll().andSelf().removeClass('ratings_hover');
        // set_votes($(this).parent());
      }
    );
    // click chọn sao
    $('.ratings_stars').on('click', function() {
      const rate = parseInt($(this).find('input').val(), 10);

      $.post(rateUrl, {
          id_blog: postId,
          rate: rate
        })
        .done(function(res) {
          // tô lại sao
          $('.ratings_stars').removeClass('ratings_over');
          $('.ratings_stars').each(function() {
            const v = parseInt($(this).find('input').val(), 10);
            if (v <= rate) $(this).addClass('ratings_over');
          });

          if (res && res.success) {
            $('#avg-rate').text(res.avg);
          }
        })
        .fail(function(xhr) {
          if (xhr.status === 401 || xhr.status === 403) {
            alert('Vui lòng đăng nhập để đánh giá!');
          } else {
            alert('Có lỗi xảy ra, thử lại.');
          }
        });
    });

    /** COMMENT */
    const isLoggedIn = "{{ auth()->check() ? 'true' : 'false' }}";

    // 2. Gửi comment CHA
    $('#main-comment-form').on('submit', function(e) {
      e.preventDefault();

      if (isLoggedIn === 'false') {
        alert('Bạn phải đăng nhập mới bình luận được');
        return;
      }

      const form = $(this);
      const data = form.serialize();

      $.post("{{ route('blog.comment') }}", data)
        .done(function(res) {
          if (res.success) {
            const c = res.data;
            const html = `
            <li class="media" data-id="${c.id}">
              <a class="pull-left" href="#">
                <img class="media-object" src="${c.avatar}" alt="">
              </a>
              <div class="media-body">
                <ul class="sinlge-post-meta">
                  <li><i class="fa fa-user"></i> ${c.name_user}</li>
                  <li><i class="fa fa-clock-o"></i> ${c.created_at}</li>
                  <li><i class="fa fa-calendar"></i> ${c.created_at_full}</li>
                </ul>
                <p>${c.content}</p>
                <a class="btn btn-primary btn-reply" href="javascript:void(0)" data-parent="${c.id}">
                  <i class="fa fa-reply"></i>Reply
                </a>
                <div class="children-box"></div>
              </div>
            </li>
          `;
            // chèn lên đầu list
            $('#comment-list').prepend(html);
            // clear textarea
            form.find('textarea[name="content"]').val('');
          }
        })
        .fail(function() {
          alert('Không gửi được bình luận, thử lại.');
        });
    });

    // 3. Bấm REPLY để hiện form trả lời 
    $('#comment-list').on('click', '.btn-reply', function() {
      if (isLoggedIn === 'false') {
        alert('Bạn phải đăng nhập mới trả lời được');
        return;
      }

      const parentId = $(this).data('parent');
      const box = $(this).closest('.media').find('.children-box').first();

      // tránh tạo nhiều form dưới 1 comment
      if (box.find('form.reply-form').length) return;

      const replyForm = `
      <form class="reply-form mt-2">
        @csrf
        <input type="hidden" name="id_blog" value="{{ $post->id }}">
        <input type="hidden" name="parent_id" value="${parentId}">
        <textarea name="content" rows="3" class="form-control" required></textarea>
        <button type="submit" class="btn btn-sm btn-success mt-1">Gửi trả lời</button>
      </form>
    `;
      box.html(replyForm);
    });

    // 4. Submit comment CON
    $('#comment-list').on('submit', 'form.reply-form', function(e) {
      e.preventDefault();

      const form = $(this);
      const data = form.serialize();

      $.post("{{ route('blog.comment') }}", data)
        .done(function(res) {
          if (res.success) {
            const c = res.data;
            const html = `
            <div class="media second-media mt-2" data-id="${c.id}">
              <a class="pull-left" href="#">
                <img class="media-object" src="${c.avatar}" alt="">
              </a>
              <div class="media-body">
                <ul class="sinlge-post-meta">
                  <li><i class="fa fa-user"></i> ${c.name_user}</li>
                  <li><i class="fa fa-clock-o"></i> ${c.created_at}</li>
                  <li><i class="fa fa-calendar"></i> ${c.created_at_full}</li>
                </ul>
                <p>${c.content}</p>
              </div>
            </div>
          `;
            // chèn reply vào trước form
            form.before(html);
            // xóa form
            form.remove();
          }
        })
        .fail(function() {
          alert('Không gửi được trả lời.');
        });
    });

  });
</script>
@endpush