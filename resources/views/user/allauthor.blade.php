@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($authors as $author)
        <div class="col-3">
            <div class="single_card">
                <div>
                    <div class="img">
                        <img src="{{ asset('uploads/profile') }}/{{ App\Models\Profile::where('user_id','=',$author->id)->first()->image }}" alt="" width="100%">
                    </div>
                    <h2>{{ $author->name }}</h2>
                    <p class="profession">{{ App\Models\Profile::where('user_id','=',$author->id)->first()->profession }}</p>
                    <p>Posted Blogs {{ App\Models\Blog::where('added_by','=',$author->id)->where('status','=','published')->get()->count() }}</p>
                    <div class="profile_link">
                        @if ($author->id == Auth::id())
                            <a href="{{ url('profile') }}">View Profile</a>
                        @else
                            <a href="{{ url('profile_visit') }}.{{ $author->id }}">View Profile</a>
                        @endif
                    </div>
                </div>
                <div>
                    <p>Skills</p>
                    @foreach ($activites = App\Models\Activity::where('added_by','=',$author->id)->get() as $activity)
                        <p class="activity">{{ $activity->activity }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
