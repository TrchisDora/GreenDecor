@extends('frontend.layouts.master')

@section('title','Ecommerce Laravel || Blog Page')

@section('main-content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Blog</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Blog</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Blog Section Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Blog Posts -->
        <div class="col-lg-8 col-md-12 col-12">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="card h-100">
                        <img src="{{ $post->photo }}" class="card-img-top" alt="{{ $post->title }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('blog.detail', $post->slug) }}" class="text-dark">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text small text-muted">
                                <i class="fa fa-calendar"></i> {{ $post->created_at->format('d M, Y. D') }}
                                <span class="float-right">
                                    <i class="fa fa-user"></i> {{ $post->author_info->name ?? 'Anonymous' }}
                                </span>
                            </p>
                            <p>{!! \Illuminate\Support\Str::limit(strip_tags($post->summary), 100) !!}</p>
                            <a href="{{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-12 d-flex justify-content-center mt-4">
                    {{-- {!! $posts->appends($_GET)->links() !!} --}}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 col-md-12 col-12">
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
    </div>
</div>
<!-- Blog Section End -->

@endsection

@push('styles')
<style>
    .card-title a:hover {
        color: #007bff;
    }
</style>
@endpush
