@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
        <a class="btn btn-secondary" href="{{route('users.index')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group" method="POST" action="{{route('users.update', $user->id)}}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Név</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                </div>
                <label class="col-4 control-label">Jogosultság</label>
                <select name='role' class="form-control mb-4">
                    @foreach($roles as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
        </div>
    </div>
</div>

  @endsection
