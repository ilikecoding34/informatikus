

<div class="container mt-2">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="list-group">
                @foreach ($post->comments as $item)
                <div class="card mb-3">
                    @if (Auth::user())
                    <a href="{{route('comments.edit', $item->id)}}" class="list-group-item list-group-item-action">

                    @endif
                    <div class="card-body">
                        <p class="card-text">{{$item->body}}</p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text text-left">
                                    <small class="text-muted">Szerző: {{$item->user->name}}</small>
                                </p>
                            </div>
                            <div class="col">
                                <p class="card-text text-right">
                                    <small class="text-muted">Utoljára frissítve: {{$item->updated_at->diffForHumans(null, true).'ja' }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user())
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
