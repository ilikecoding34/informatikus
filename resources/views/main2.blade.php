@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col order-1">
            First in DOM, no order applied
        </div>
        <div class="col order-2">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col order-3">
            Third in DOM, with an order of 1
        </div>
    </div>
</div>
@endsection
