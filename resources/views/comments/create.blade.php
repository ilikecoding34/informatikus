

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group" method="POST" action="{{route('comments.store')}}">
                @csrf
                <input type="hidden" class="form-control" name="post" id="body" value="{{$post->id}}">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Komment</label>
                    <input type="text" class="form-control" name="body" id="body" value="">
                </div>
                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

