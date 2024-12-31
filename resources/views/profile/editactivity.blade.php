@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">

            <nav class="breadcrumb_area" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('profile') }}">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Activity</li>
                </ol>
            </nav>
            <div class="profile_edit card card-body">
                <h4>Your Activity</h4>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ url('activity.insert') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row align-items-center">
                        <label for="activityname" class="col-sm-4 col-form-label">Activity Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputName" name="activityname" value="" required>
                        </div>
                        @error('activityname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <button type="submit" id="submitBtn" class="btn btn-success">Add</button>
                    </div>
                </form>
                <div class="card mt-2">
                    <div class="card-body">
                        @foreach ($activities as $activity)
                            <span class="badge text-bg-primary">{{ $activity->activity }} <a href="{{ url('activity.delete') }}.{{ $activity->id }}" class="btn"><i class="fa-solid fa-xmark"></i></a></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
