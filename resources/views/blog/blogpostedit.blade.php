@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ url('blogpost.edit') }}" enctype="multipart/form-data">
                    <!-- CSRF Token for Laravel -->
                    @csrf
                    <input type="text" name="id" id="id" hidden value="{{ $blog->id }}">
                    <!-- Blog Title -->
                    <div class="mb-3">
                        <label for="title">Blog Title:</label>
                        <input class="form-control" type="text" id="title" name="title" value="{{ $blog->title }}" placeholder="Enter blog title" required>
                    </div>

                    <!-- Blog Content -->
                    <div class="mb-3">
                        <label for="content">Content:</label>
                        <textarea class="form-control" id="content" name="content" rows="10" placeholder="Write your blog content here...">{{ $blog->content }}</textarea>
                    </div>

                    <!-- Blog Category -->
                    <div class="mb-3">
                        <label for="category">Category:</label>

                        <select class="form-control" id="category" name="category" required>
                            <option value="" disabled {{ !isset($blog) ? 'selected' : '' }}>Select a category</option>
                            @foreach ($blogcategories as $blogcategory)
                                <option value="{{ $blogcategory->name }}" {{ isset($blog) && $blog->category == $blogcategory->name ? 'selected' : '' }}>{{ $blogcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Blog Thumbnail Image -->
                    <div class="mb-3">
                        <label for="thumbnail">Thumbnail Image:</label>
                        <!-- Display the previous image if it exists -->
                        @if(isset($blog) && $blog->thumbnail)
                            <div>
                                <img src="{{ asset('uploads/thumbnail/' . $blog->thumbnail) }}" alt="Previous Thumbnail" width="150" class="mb-3">
                            </div>
                        @endif
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*">
                        <span class="bg-warning">Note: If you want to change Thumbnail, Just upload it. If you don't then dont upload anything.</span>
                    </div>

                    <!-- Publish Status -->
                    <div class="mb-3">
                        <label for="status">Publish Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <!-- Set the current status as selected option -->
                            <option value="draft" {{ isset($blog) && $blog->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ isset($blog) && $blog->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button class="btn btn-primary" type="submit">Edit Blog</button>
                        <a href="{{ url("blogpost")}}" class="btn btn-danger" >Cancle</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
