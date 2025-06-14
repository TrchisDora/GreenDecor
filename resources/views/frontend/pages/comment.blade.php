@foreach($comments as $comment)
    @php $dep = $depth-1; @endphp
    <div class="comment-container" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <div class="comment-list shadow-sm rounded-3 mb-4 bg-light">
            <div class="single-comment p-3 d-flex align-items-start">
                {{-- Avatar của người bình luận --}}
                <div class="comment-avatar mr-3">
                    @if($comment->user_info['photo'])
                        <img src="{{$comment->user_info['photo']}}" alt="#" class="rounded-circle shadow-sm" width="50" height="50">
                    @else 
                        <img src="{{asset('backend/img/avatar.png')}}" alt="avatar" class="rounded-circle shadow-sm" width="50" height="50">
                    @endif
                </div>
                
                {{-- Nội dung bình luận --}}
                <div class="comment-content flex-grow-1">
                    <h5 class="comment-author mb-1">
                        {{$comment->user_info['name']}} 
                        <span class="text-muted small">at {{$comment->created_at->format('g:i a')}} on {{$comment->created_at->format('M d Y')}}</span>
                    </h5>
                    <p class="comment-text mb-2">{{ $comment->comment }}</p>
                    
                    {{-- Nếu có thể trả lời --}}
                    @if($dep)
                    <div class="button">
                        <a href="#" class="btn btn-reply reply" data-id="{{$comment->id}}"><i class="fa fa-reply" aria-hidden="true"></i>Trả lời</a>
                        <a href="" class="btn btn-reply cancel" style="display: none;" ><i class="fa fa-trash" aria-hidden="true"></i>Hủy</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Hiển thị trả lời bình luận (nếu có) --}}
        @include('frontend.pages.comment', ['comments' => $comment->replies, 'depth' => $dep])
    </div>
@endforeach
