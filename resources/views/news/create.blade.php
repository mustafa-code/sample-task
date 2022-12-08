@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{ route("news.store") }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" 
                            placeholder="Title of a news..." required="required">
                            @error('title')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea type="text" class="form-control" name="content" id="content" 
                            rows="3" placeholder="Content of a news..." required="required"></textarea>
                            @error('content')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

