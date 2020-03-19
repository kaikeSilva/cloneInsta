@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{ $post->image }}" class="w-100" alt="">
            </div>
            <div class="col-4">
                <div class="d-flex align-items-center mb-5">
                    <div class="col-5">
                        <img src="{{$post->user->profile->profileImage()}}" class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="col-7">
                        <a href="/profile/{{ $post->user->id }}">
                            <div class="font-weight-bold text-dark">
                                {{ $post->user->username }}
                            </div>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="p-1">
                    <p class="">
                        <a href="/profile/{{ $post->user->id }}">
                            <spam class="font-weight-bold text-dark">
                                {{ $post->user->username }}
                            </spam>
                        </a>
                        {{ $post->caption }}
                    </p>
                </div>

            </div>
        </div>
        
    </div>
@endsection
