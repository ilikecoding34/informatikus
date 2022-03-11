@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-end">
            <a class="btn btn-secondary" href="{{route('roles.index')}}" role="button">Vissza</a>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form class="form-group">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Role elnevezés</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$role->name}}">

                </div>

                <a class="btn btn-secondary" href="{{route('roles.edit', $role->id)}}" role="button">Szerkeszt</a>
            </form>
        </div>
    </div>
</div>

  @endsection
