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
                        {{-- @foreach ($userlist as $user)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at->format('d/m/y A') }}<br><span class="badge bg-success">{{ $user->created_at->diffForHumans() }}</span></td>
                                <td>
                                    @if ($user->role !== "Admin")
                                        <a href="{{ url('user.delete') }}.{{ $user->id }}" class="btn btn-danger btn-sm">Delete</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
            <div class="col-4">
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
@endsection
