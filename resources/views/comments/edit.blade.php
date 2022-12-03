@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group" method="POST" action="{{route('comments.update', $comment->id)}}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Komment</label>
                    <textarea class="form-control" rows={{str_word_count($comment->body)/12}} name="body" id="body">{{$comment->body}}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

  @endsection
