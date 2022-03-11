@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
            <a class="btn btn-secondary" href="{{route('categories.index')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group" method="POST" action="{{route('categories.update', $category->id)}}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cím</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$category->name}}">

                </div>

                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

  @endsection
