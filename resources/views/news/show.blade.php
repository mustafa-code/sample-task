@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">News Page</h3>
                        </div>
                        @if (auth()->user()->id == $news_item->user_id)
                        <div class="col" style="text-align: right;">
                            <a href="{{ route("news.edit", $news_item->id) }}">Edit</a>
                            <form class="d-inline" id="delete-news" action="{{ route("news.destroy", $news_item->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <a class="mx-4" href="{{ route("news.destroy", $news_item->id) }}" onclick="event.preventDefault();
                                document.getElementById('delete-news').submit();">Delete</a>
                            </form>
    
                        </div>        
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $news_item->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $news_item->user->name }}</h6>
                    <p class="card-text">{{ $news_item->content }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

