@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
            <a class="btn btn-info" href="{{route('posts.create')}}" role="button">Új bjegyzés írása</a>
    </div>
</div>

<div class="container mt-2">
    <div class="row justify-content-center">
        @if ($user_settings->column_number==2 || $user_settings->column_number==3)
        <div class="col-md-3
        @if ($user_settings->column_number==3)
            order-last
        @endif ">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        @if ($user_settings->column_number==2)
                            @if(in_array(3,$user_settings->order_type))
                                Comments
                            @else
                                Top related
                            @endif
                        @endif
                        @if ($user_settings->column_number==3)
                            @if($user_settings->order_type[2] == 1)
                                Top related
                            @else
                                Comments
                            @endif
                        @endif
                    </h5>
                    <p class="card-text">Ez egy rövid leírás, talán az első 50 karakter</p>
                    <div class="row">
                        <div class="col">
                            <p class="card-text text-left">
                                <small class="text-muted">Szerző:</small>
                            </p>
                        </div>
                        <div class="col">
                            <p class="card-text text-right">
                                <small class="text-muted">Utoljára frissítve 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
        <div class="col-md-6
        @if ($user_settings->column_number==2)
            @if ($user_settings->order_type[0] == 2)
                order-first
            @else
                order-last
            @endif
            @endif">
            <div class="list-group">
                @foreach ($posts as $item)
                <div class="card mb-3">
                    <a href="{{route('posts.show', $item->id)}}" class="list-group-item list-group-item-action">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->title}}</h5>
                        <p class="card-text">{{$item->body}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
                                    <small class="text-muted">Szerző:{{$item->user->name}}</small>
                                </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-right">
                                    <small class="text-muted">Utoljára frissítve: {{$item->updated_at->diffForHumans(null, true).'ja' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @if ($user_settings->column_number==3)
        <div class="col-md-3
        @if ($user_settings->column_number==3)
            order-first
        @endif ">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">

                            @if($user_settings->order_type[0] == 1)
                                Top related
                            @else
                                Comments
                            @endif

                    </h5>
                    <p class="card-text">Ez egy rövid leírás, talán az első 50 karakter</p>
                    <div class="row">
                        <div class="col">
                            <p class="card-text text-left">
                                <small class="text-muted">Szerző:</small>
                            </p>
                        </div>
                        <div class="col">
                            <p class="card-text text-right">
                                <small class="text-muted">Utoljára frissítve 3 mins ago</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

  @endsection
