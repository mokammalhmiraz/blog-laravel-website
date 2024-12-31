@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">

            <nav class="breadcrumb_area" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('profile') }}">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile Edit</li>
                </ol>
            </nav>
            <div class="profile_edit card card-body">
                <h4>Edit Your Profile Information</h4>
                <form method="POST" action="{{ url('profile.insert') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="formFile" class="col-sm-2 col-form-label">Profile Picture</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="formFile" name="image" placeholder="Upload Your Image">
                        </div>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $user_info->mail }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name" value="{{ $user_info->name }}">
                        </div>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 row">
                        <label for="inputProfession" class="col-sm-2 col-form-label">Profession</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputProfession" name="profession" value="{{ $user_info->profession }}" >
                        </div>
                        @error('profession')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 row">
                        <label for="intro" class="col-sm-2 col-form-label">Intro</label>
                        <div class="col-sm-10">
                            <textarea rows="2" style="width: 100%;" type="text" class="form-control" id="intro" name="intro">{{ $user_info->intro }}</textarea>
                            <small id="wordCountError" class="text-danger" style="display:none;">Intro must not exceed 50 words.</small>
                            @error('intro')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputAddress" name="address" value="{{ $user_info->address }}" >
                        </div>
                    </div>
                    <div>
                        <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
