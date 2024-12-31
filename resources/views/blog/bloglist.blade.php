@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <form class="d-flex justify-content-between" action="{{ url('bloglist') }}" method="GET">
                    @csrf
                    <input type="text" name="query" placeholder="Search blogs..." class="form-control">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-4">
                    <div class="single_blog blog_list">
                        <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" alt="{{ $blog->thumbnail }}" width="100%">
                        <div class="blog">
                            <div class="blog_text">
                                <span class="badge text-bg-secondary">{{ $blog->category }}</span>
                                <h3>{{ $blog->title }}</h3>
                                <p class="truncate">{{ $blog->content }}</p>
                            </div>
                            <div class="info">
                                <div class="wrap">
                                    {{-- {{ App\Models\Profile::where('user_id','=',$blog->added_by)->first()->id }} --}}
                                    <div class="img">
                                        <img src="{{ asset('uploads/profile') }}/{{ App\Models\Profile::where('user_id','=',$blog->added_by)->first()->image }}" alt="" width="100%">
                                    </div>
                                    <div>
                                        <a href="{{ url('blog.profile_visit') }}.{{ $blog->added_by }}">
                                            <p>{{ App\Models\User::find($blog->added_by)->name }}</p>
                                        </a>
                                        <span>{{ $blog->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <a href="{{ url('bloglist.view') }}.{{ $blog->id }}" class="read_more">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
