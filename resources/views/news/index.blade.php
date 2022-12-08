@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($news as $news_item)
            <div class="card mb-4">
                <div class="card-body">
                    <a href="{{ route("news.show", $news_item->id) }}">
                        <h5 class="card-title">{{ $news_item->title }}</h5>
                    </a>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $news_item->user->name }}</h6>
                    <p class="card-text">{{ $news_item->content }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection

