@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if ( App\Models\User::find(Auth::id())->status == 1)
                <div class="col-6">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('blogpost.insert') }}" enctype="multipart/form-data">
                        <!-- CSRF Token for Laravel -->
                        @csrf

                        <!-- Blog Title -->
                        <div class="mb-3">
                            <label for="title">Blog Title:</label>
                            <input class="form-control" type="text" id="title" name="title" placeholder="Enter blog title" required>
                        </div>

                        <!-- Blog Content -->
                        <div class="mb-3">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="content" rows="10" placeholder="Write your blog content here..."></textarea>
                        </div>

                        <!-- Blog Category -->
                        <div class="mb-3">
                            <label for="category">Category:</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach ($blogcategories as $blogcategory)
                                    <option value="{{ $blogcategory->name }}">{{ $blogcategory->name }}</option>
                                @endforeach


                                {{-- <option value="Health">Health</option>
                                <option value="Travel">Travel</option>
                                <option value="Food">Food</option> --}}
                            </select>
                        </div>

                        <!-- Blog Thumbnail Image -->
                        <div class="mb-3">
                            <label for="thumbnail">Thumbnail Image:</label>
                            <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*">
                        </div>

                        <!-- Publish Status -->
                        <div class="mb-3">
                            <label for="status">Publish Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button class="btn btn-primary" type="submit">Submit Blog</button>
                        </div>
                    </form>
                </div>
            @else
                <div>
                    <h2 class="alert alert-warning text-center">!Before Posting A Blog You Need To Get Approved By The Admin!</h2>
                </div>
            @endif
            <div class="blog-card-list">
                <h2 class="fw-bold title">Your Blog List</h2>
                @if ($blogs->isEmpty())
                    <div class="alert alert-info text-center">
                        No blog posted yet.
                    </div>
                @else
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
                @endif
            </div>
        </div>
    </div>
@endsection
