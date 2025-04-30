@extends('frontend.layouts.master')

@section('title', 'E-TECH || Blog Detail page')

@section('main-content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Blog Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Blog Single Sidebar</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Blog Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Main Blog Content Start -->
            <div class="col-lg-8 col-md-12 col-12">
            <div class="blog-single-main py-5 px-3 px-md-5 bg-white rounded shadow-sm">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        {{-- Hình ảnh bài viết --}}
                        <div class="post-thumbnail overflow-hidden rounded-4 mb-4 shadow-sm">
                            <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
                        </div>
                        {{-- Tiêu đề và metadata --}}
                        <div class="blog-detail mb-5">
                            <h1 class="display-4 fw-bold text-primary mb-3">{{ $post->title }}</h1>

                            <div class="blog-meta small text-muted d-flex flex-wrap gap-3 align-items-center mb-4">
                                <span class="mr-3"><i class="fa fa-user me-1 text-success"></i> {{ $post->author_info['name'] }}</span>
                                <span class="mr-3"><i class="fa fa-calendar me-1 text-success"></i> {{ $post->created_at->format('M d, Y') }}</span>
                                <span class="mr-3"><i class="fa fa-comments me-1 text-success"></i> {{ $post->allComments->count() }} comments</span>
                            </div>
                            {{-- Share buttons --}}
                            <div class="mb-4">
                                <div class="sharethis-inline-reaction-buttons"></div>
                            </div>
                            {{-- Nội dung --}}
                            <div class="content fs-5 lh-lg text-dark">
                                @if($post->quote)
                                    <blockquote class="blockquote bg-light border-start border-5 border-primary ps-4 py-3 rounded shadow-sm mb-4 position-relative">
                                        <i class="fa fa-quote-left text-primary position-absolute top-0 start-0 mt-3 ms-3 fs-3 opacity-25"></i>
                                        <p class="mb-0">{!! $post->quote !!}</p>
                                    </blockquote>
                                @endif

                                <div>{!! $post->description !!}</div>
                            </div>
                            {{-- Tags --}}
                            <div class="mt-5 border-top pt-4">
                                <h5 class="text-dark fw-bold mb-3">Tags</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @php $tags = explode(',', $post->tags); @endphp
                                    @foreach($tags as $tag)
                                        <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm rounded-pill shadow-sm px-3 mr-1">{{ $tag }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- Form bình luận --}}
                        <div class="mt-5">
                            @auth
                                <div class="card border-0 shadow-sm rounded-4 p-4">
                                    <h3 class="mb-4 text-primary">💬 Leave a Comment</h3>
                                    <form id="commentForm" action="{{ route('post-comment.store', $post->slug) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="comment" class="form-label fw-semibold">Your Comment <span class="text-danger">*</span></label>
                                            <textarea name="comment" id="comment" rows="6" class="form-control rounded-3" placeholder="Share your thoughts..."></textarea>
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input type="hidden" name="parent_id" id="parent_id" value="">
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                                            <i class="fa fa-paper-plane me-1"></i> Post Comment
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert-warning text-center p-4 rounded-3 shadow-sm">
                                    You need to 
                                    <a href="{{ route('login.form') }}" class="btn btn-sm btn-outline-primary ms-2 me-2">Login</a> 
                                    or 
                                    <a href="{{ route('register.form') }}" class="btn btn-sm btn-outline-success">Register</a> 
                                    to leave a comment.
                                </div>
                            @endauth
                        </div>
                        {{-- Danh sách bình luận --}}
                        <div class="comments mt-5">
                            <h3 class="mb-4 text-dark fw-bold">💬 Comments ({{ $post->allComments->count() }})</h3>
                            @include('frontend.pages.comment', ['comments' => $post->comments, 'post_id' => $post->id, 'depth' => 3])
                        </div>
                    </div>
                </div>
            </div>

            </div>
            <!-- Main Blog Content End -->
            <!-- Sidebar Start -->
            <div class="col-lg-4 col-12">
            <aside class="blog-sidebar">
                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-search"></i> Search
                    </div>
                    <div class="card-body bg-secondary text-primary">
                        <form method="GET" action="{{ route('blog.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Here..." name="search">
                                <div class="input-group-append">
                                    <button class="btn btn-dark" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-list"></i> Categories
                    </div>
                    <ul class="list-group list-group-flush bg-secondary text-primary">
                        @foreach(Helper::postCategoryList('posts') as $cat)
                            <li class="list-group-item bg-secondary border-0">
                                <a href="{{ route('blog.category', $cat->slug) }}" class="text-primary">{{ $cat->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-clock"></i> Recent Posts
                    </div>
                    <div class="card-body bg-secondary text-primary">
                        @foreach($recent_posts as $post)
                            <div class="media mb-3 border-bottom pb-2">
                                <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="mr-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">
                                        <a href="{{ route('blog.detail', $post->slug) }}" class="text-primary">{{ $post->title }}</a>
                                    </h6>
                                    <small class="text-primary">
                                        <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M, y') }}<br>
                                        <i class="fa fa-user"></i> {{ $post->author_info->name ?? 'Anonymous' }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-tags"></i> Tags
                    </div>
                    <div class="card-body bg-secondary text-primary">
                        @foreach(Helper::postTagList('posts') as $tag)
                            <a href="{{ route('blog.tag', $tag->title) }}" class="badge badge-light m-1 text-primary">{{ $tag->title }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-envelope"></i> Newsletter
                    </div>
                    <div class="card-body bg-secondary text-primary">
                        <form method="POST" action="{{ route('subscribe') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter your email">
                            </div>
                            <button type="submit" class="btn btn-dark btn-block">Subscribe</button>
                        </form>
                    </div>
                </div>
            </aside>
            </div>
            <!-- Sidebar End -->
        </div>
    </div>
    <!-- Blog End -->
@endsection

@push('styles')
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
@endpush

@push('scripts')
<script>
$(document).ready(function(){
    (function($) {
        "use strict";
        
        $('.btn-reply.reply').click(function(e){
            e.preventDefault();
            $('.btn-reply.reply').show();
            $('.comment_btn.comment').hide();
            $('.comment_btn.reply').show();
            $(this).hide();
            $(this).siblings('.btn-reply.cancel').show();
            var parent_id = $(this).data('id');
            var html = $('#commentForm');
            $(html).find('#parent_id').val(parent_id);
            $('#commentFormContainer').hide();
            $(this).parents('.comment-list').append(html).fadeIn('slow').addClass('appended');
        });

        $('.comment-list').on('click','.btn-reply.cancel',function(e){
            e.preventDefault();
            $(this).hide();
            $('.btn-reply.reply').show();
            $('.comment_btn.reply').hide();
            $('.comment_btn.comment').show();
            $('#commentFormContainer').show();
            var html = $('#commentForm');
            $(html).find('#parent_id').val('');
            $('#commentFormContainer').append(html);
        });

    })(jQuery)
})
</script>
@endpush
