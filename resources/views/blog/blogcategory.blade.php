@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <h2 class="fw-bold title">Blog Category List</h2>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $category->name }}</td>
                                <td>{{ App\Models\User::find($category->added_by)->name }}</td>
                                <td><a href="{{ url('category.delete') }}.{{ $category->id }}" class="btn btn-danger btn-sm">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <div class="card" >
                    <div class="card-body">
                        <form method="POST" action="{{ url('blogcategory.insert') }}" enctype="multipart/form-data">
                            <!-- CSRF Token for Laravel -->
                            @csrf

                            <!-- Blog Title -->
                            <div class="mb-3">
                                <label for="title">Blog Category</label>
                                <input class="form-control" type="text" id="category" name="category" placeholder="Enter Blog Category" required>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button class="btn btn-primary" type="submit">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
