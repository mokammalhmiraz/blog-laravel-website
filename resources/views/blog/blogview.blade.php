@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <nav class="breadcrumb_area" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('bloglist') }}">Blog List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
                    </ol>
                </nav>
                <div class="blog-container">
                    <div class="blog-header">
                        <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" class="card-img-top" alt="thumbnail">
                        <div class="blog-cover">
                            <a href="{{ url('blog.profile_visit') }}.{{ $blog->added_by }}">
                                <div class="blog-author">
                                    <div class="blog_img">
                                        <img src="{{ asset('uploads/profile') }}/{{ App\Models\Profile::where('user_id','=',$blog->added_by)->first()->image }}" alt="" width="100%">
                                    </div>
                                    <h3>{{ App\Models\User::find($blog->added_by)->name }}</h3>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="blog-body">
                        <div class="blog-title">
                          <h1>{{ $blog->title }}</h1>
                        </div>
                        <div class="blog-summary">
                          <p>{{ $blog->content }}</p>
                        </div>
                        <div class="blog-tags">
                            <span>{{ $blog->category }}</span>
                        </div>
                    </div>
                    <div class="bar"></div>
                    <div class="blog-footer">
                        <div>
                          <span class="">{{ $blog->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="wrap">
                            <div class="reaction-btns">
                                @if (($reaction)===0)
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
                        </div>
                    </div>
                    <div class="cmnt" style="display: none;">
                        <form method="POST" action="{{ url('blogpost.comment') }}">
                            @csrf
                            <div class="comment mb-3">
                                <input type="text" name="blog_id" value="{{ $blog->id }}" hidden>
                                <input type="text" class="" name="content" placeholder="Write Your Comment" aria-label="Write Your Comment" aria-describedby="basic-addon1" width="100%">
                                <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="cmnt_view">
                        @foreach ($comments as $comment)
                            {{-- <div class="comment_list">
                                <div class="wrap">
                                    <h6>{{ App\Models\User::find($comment->user_id)->name }}</h6>
                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comments">{{ $comment->content }}</p>
                            </div> --}}
                            <div class="comment-container">
                                <div class="comment-header">
                                    <a href="{{ url('profile_visit') }}.{{ $comment->user_id }}">
                                        <div class="wrap">
                                            <div class="img">
                                                <img src="{{ asset('uploads/profile') }}/{{ App\Models\Profile::where('user_id','=',$comment->user_id)->first()->image }}" alt="" width="100%">
                                            </div>
                                            <span class="comment-author">{{ App\Models\User::find($comment->user_id)->name }}</span>
                                        </div>
                                    </a>
                                    <span class="comment-timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-body">
                                    {{ $comment->content }}
                                </div>
                              </div>
                        @endforeach
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
                $(this).closest('.blog-container').find('.cmnt').toggle();
            });
        });
    </script>
@endsection
