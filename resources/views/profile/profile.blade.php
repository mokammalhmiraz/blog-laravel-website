@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-3">
            <div class="profile_info">
                <div class="img">
                    @if ($data->image == Null)
                        <i class="fa-regular fa-user"></i>
                    @else
                        <img src="{{ asset('uploads/profile') }}/{{ $data->image }}" alt="" width="100%">
                    @endif
                </div>
                <div>
                    <div class="wrap">
                        <h4 class="name">{{ App\Models\User::find($data->user_id)->name }}</h4>
                        <a href="{{ url('editprofile') }}" class=""><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                    <div class="profession wrap">
                        <p>Profession</p>
                        <p>{{ $data->profession }}</p>
                    </div>
                </div>
                <div class="intro">
                    <p>{{ $data->intro }}</p>
                </div>
                <div class="activity wrap">
                    <p>Activity</p>
                    <a href="{{ url('editactivity') }}" class=""><i class="fa-solid fa-plus"></i></a>
                </div>
                <div>
                    @foreach ($activities as $activity)
                        <span class="badge text-bg-primary">{{ $activity->activity }}</span>
                    @endforeach
                </div>
                <div class="address">
                    <p>Address:</p>
                    <span>{{ $data->address }}</span>
                </div>
                <div>

                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="profile">
                <div class="wrap">
                    <h4>Your Posted Blogs</h4>
                    <a href="{{ url("blogpost")}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add Blogs</a>
                </div>
                <div class="row">
                    @foreach ($blogs as $blog)

                    <div class="col-4">
                        <div class="single_blog {{ $blog->status === 'draft' ? 'bg' : 'active' }}">
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
                                            <p>{{ App\Models\User::find($blog->added_by)->name }}</p>
                                            <span>{{ $blog->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" >
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">

                                            @if ($blog->status == "draft")
                                                <li><a href="{{ url('blogpost.publish') }}.{{ $blog->id }}" class="dropdown-item ">Make Publish</a></li>
                                            @else
                                                <li><a href="{{ url('blogpost.draft') }}.{{ $blog->id }}" class="dropdown-item ">Make Draft</a></li>
                                            @endif
                                            <li><a href="{{ url('blogpost.delete') }}.{{ $blog->id }}" class="dropdown-item ">Delete</a></li>
                                            <li><a href="{{ url('blogpost.edit') }}.{{ $blog->id }}" class=" dropdown-item ">Edit</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
