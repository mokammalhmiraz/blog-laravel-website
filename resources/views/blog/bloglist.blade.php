@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-4">
                    <div class="card blog-card">
                        <img src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" class="card-img-top" alt="thumbnail">
                        <div class="card-body">
                            <div class="wrap">
                                <div>
                                    <h5 class="card-title fw-bold d-inline ">{{ $blog->title }}</h5><span>{{ $blog->category }}</span>
                                </div>
                                <p>Post by <span class="author_name">{{ App\Models\User::find($blog->added_by)->name }}</span></p>
                            </div>
                            <p class="card-text truncate">{{ $blog->content }}</p>
                            {{-- <a href="{{ url('bloglist.view') }}.{{ $blog->id }}" class="btn btn-primary">View Full</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
