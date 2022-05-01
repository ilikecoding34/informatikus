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
            <form class="form-group" method="POST" action="{{route('posts.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cím</label>
                    <input type="text" class="form-control" name="title" id="title" value="">
                    <div class="form-text">Ez a bejegyzés címe lesz</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Link</label>
                    <input type="text" class="form-control" name="link" id="link" value="">
                    <div class="form-text">Ide beszúrható egy link</div>
                </div>
                <div class="mb-3">
                    <label for="floatingTextarea" class="form-label">Szöveg</label>
                    <textarea class="form-control" placeholder="Bejegyzés tartalma" name="content"></textarea>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-4">
                        <label class="col-4 control-label">Kategória</label>
                        <select name='category' class="form-control" >
                            @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="col-4 control-label">Tags</label>
                        <select name='tags[]' multiple class="form-control">
                            @foreach ($tags as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

  @endsection
