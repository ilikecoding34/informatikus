@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
            <a class="btn btn-secondary" href="{{route('posts.index')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group" method="POST" action="{{route('posts.update', $post->id)}}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cím</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$post->title}}">
                    <div class="form-text">Ez a bejegyzés címe lesz</div>
                </div>
                <div class="mb-3">
                    <label for="floatingTextarea" class="form-label">Szoveg</label>
                    <textarea class="form-control" placeholder="Leave a comment here" name="content">{{$post->body}}</textarea>
                </div>
                <div class="col-xs-2">
                    <label class="col-xs-3 control-label">Kategória</label>
                    <select name='category' class="form-control" style="width:auto;">
                        <option value="1">Short</option>
                        <option value="2">Medium lenght
                        </option>
                        <option value="3">Much much much longer text not fitting when resizing
                        </option>
                    </select>
                </div>
                <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="active">
                <label class="form-check-label" for="exampleCheck1">Aktív</label>
                </div>
                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

  @endsection
