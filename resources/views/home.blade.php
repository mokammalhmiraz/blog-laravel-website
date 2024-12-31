@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col-4">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        Welcome, {{ Auth::user()->name }}
                        <br>

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-6">
                    <div class="card">
                        <div class="card__image">
                            <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" alt="{{ $blog->thumbnail }}" alt="" width="100%">

                            <div class="card__overlay card__overlay--indigo">
                                <div class="card__overlay-content">
                                    <ul class="card__meta">
                                        <li><a href="#0"><i class="fa fa-tag"></i> {{ $blog->category }}</a></li>
                                        <li><a href="#0"><i class="fa fa-clock-o"></i> {{ $blog->created_at->diffForHumans() }}</a></li>
                                    </ul>

                                    <span href="#0" class="card__title">{{ $blog->title }}</span>

                                    <ul class="card__meta card__meta--last">
                                        <li><a href="#0"><i class="fa fa-user"></i> {{ App\Models\User::find($blog->added_by)->name }}</a></li>
                                        <li><a href="{{ url('bloglist.view') }}.{{ $blog->id }}" class="read_more">Read More</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="blog_slider">
                <h4>Trending Blogs</h4>
                <div class="slider">
                    @foreach ($allblogs as $blog)
                        <div class="col-4">
                            <div class="card">
                                <div class="card__image">
                                    <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" alt="{{ $blog->thumbnail }}" alt="" width="100%">

                                    <div class="card__overlay card__overlay--indigo">
                                        <div class="card__overlay-content">
                                            <ul class="card__meta">
                                                <li><a href="#0"><i class="fa fa-tag"></i> {{ $blog->category }}</a></li>
                                                <li><a href="#0"><i class="fa fa-clock-o"></i> {{ $blog->created_at->diffForHumans() }}</a></li>
                                            </ul>

                                            <span href="#0" class="card__title">{{ $blog->title }}</span>

                                            <ul class="card__meta card__meta--last">
                                                <li><a href="#0"><i class="fa fa-user"></i> {{ App\Models\User::find($blog->added_by)->name }}</a></li>
                                                <li><a href="{{ url('bloglist.view') }}.{{ $blog->id }}" class="read_more">Read More</a></li>
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
@endsection
