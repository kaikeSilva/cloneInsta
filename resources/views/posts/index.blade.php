@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($posts as $post)
        <div class="row box-shadow">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $post->user->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="">
                </a>
            </div>
        </div>

        <div class="row pt-2 pb-4">
                <div class="col-6 offset-3">
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
    @endforeach

    <!--
        adicionar link para carregar mais posts, é um complemento de paginate() que foi
        usada na controller.
    -->
    <div class="row ">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
    
</div>
@endsection
