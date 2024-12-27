@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-start">
            <a href="{{ url('bloglist') }}" class="bredcum">
                <i class="fa-solid fa-angle-left"></i>
                Go Back
            </a>
            <div class="col-6">
                <div class="card blog-card">
                    <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" class="card-img-top" alt="thumbnail">
                    <div class="card-body">
                        <div class="wrap">
                            <div>
                                <h5 class="card-title fw-bold d-inline ">{{ $blog->title }}</h5><span>{{ $blog->category }}</span>
                            </div>
                            <p>Post by <span class="author_name">{{ App\Models\User::find($blog->added_by)->name }}</span></p>
                        </div>
                        <p class="card-text">{{ $blog->content }}</p>
                        <div class="reaction-btns">
                            @if (($reaction)==0)
                                <div class="thumbs-up">
                                    <a href="{{ url('blogpost.like') }}.{{ $blog->id }}" class="" >
                                        <i class="fa-solid fa-thumbs-up"></i>
                                    </a>
                                    <span >{{ $blog->likes }}</span>
                                </div>
                                <div class="thumbs-down">
                                    <a href="{{ url('blogpost.dislike') }}.{{ $blog->id }}" class="">
                                        <i class="fa-solid fa-thumbs-down"></i>
                                    </a>
                                    <span>{{ $blog->dislikes }}</span>
                                </div>
                            @else
                                <div class="thumbs-up">
                                    <a href="{{ url('blogpost.like') }}.{{ $blog->id }}" class="{{ $reaction->reaction === 'Like' ? 'active' : '' }}" >
                                        <i class="fa-solid fa-thumbs-up"></i>
                                    </a>
                                    <span >{{ $blog->likes }}</span>
                                </div>
                                <div class="thumbs-down">
                                    <a href="{{ url('blogpost.dislike') }}.{{ $blog->id }}" class="{{ $reaction->reaction === 'Dislike' ? 'active' : '' }}">
                                        <i class="fa-solid fa-thumbs-down"></i>
                                    </a>
                                    <span>{{ $blog->dislikes }}</span>
                                </div>
                            @endif

                        </div>
                        <div class="cmnt-btn">
                            <a href="#" class="comment-toggle-btn"><i class="fa-solid fa-comment"></i> Comment</a>
                        </div>
                        <div class="cmnt" style="display: none;">
                            <form method="POST" action="{{ url('blogpost.comment') }}">
                                @csrf
                                <div class="comment mb-3">
                                    <input type="text" name="blog_id" value="{{ $blog->id }}" hidden>
                                    <input type="text" class="" name="content" placeholder="Write Your Comment" aria-label="Write Your Comment" aria-describedby="basic-addon1">
                                    <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                        <div>
                            @foreach ($comments as $comment)
                                <div class="comment_list">
                                    <div class="wrap">
                                        <h6>{{ App\Models\User::find($comment->user_id)->name }}</h6>
                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="comments">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Using jQuery to toggle visibility
        $(document).ready(function() {
            $('.comment-toggle-btn').click(function(e) {
                e.preventDefault();
                // Toggle visibility of the comment input
                $(this).closest('.card-body').find('.cmnt').toggle();
            });
        });
    </script>
@endsection
