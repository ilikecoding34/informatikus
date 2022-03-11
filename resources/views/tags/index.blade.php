@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
            <a class="btn btn-info" href="{{route('tags.create')}}" role="button">Új tag keszítése</a>
    </div>
</div>

<div class="container mt-2">
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="list-group">
                @foreach ($tags as $item)
                <div class="card mb-3">
                    <a href="{{route('tags.show', $item->id)}}" class="list-group-item list-group-item-action">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

  @endsection
