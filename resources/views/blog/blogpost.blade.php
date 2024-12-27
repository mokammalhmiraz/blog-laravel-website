@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
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
                            <option value="Technology">Technology</option>
                            <option value="Health">Health</option>
                            <option value="Travel">Travel</option>
                            <option value="Food">Food</option>
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
            <div class="blog-card-list">
                <h2 class="fw-bold title">Your Blog List</h2>
                @if ($blogs->isEmpty())
                    <div class="alert alert-info text-center">
                        No blog posted yet.
                    </div>
                @else
                    @foreach ($blogs as $blog)
                        <div class="col-12 blog-card {{ $blog->status === 'draft' ? 'bg' : '' }}">
                            <div class="row align-items-center">
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-4">
                                            <div>
                                                <img class="" width="100%" src="{{ asset('uploads/thumbnail') }}/{{ $blog->thumbnail }}" alt="thumbnail">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div>
                                                <div>
                                                    <h2 class="fw-bold d-inline">{{ $blog->title }}</h2><span>{{ $blog->category }}</span>
                                                </div>
                                                <p>{{ $blog->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class='btns'>
                                        <div class="btns-grp">
                                            @if ($blog->status == "draft")
                                                <a href="{{ url('blogpost.publish') }}.{{ $blog->id }}" class="btn btn-success">Publish</a>
                                            @else
                                                <a href="{{ url('blogpost.draft') }}.{{ $blog->id }}" class="btn btn-warning">Draft</a>
                                            @endif
                                            <a href="{{ url('blogpost.delete') }}.{{ $blog->id }}" class="btn btn-danger">Delete</a>
                                        </div>
                                        <div class="btns-single">
                                            <a href="{{ url('blogpost.edit') }}.{{ $blog->id }}" class="btn btn-info">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
