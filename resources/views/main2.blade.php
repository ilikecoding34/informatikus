@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if ($settings->col_comment)
        <div class="col order-{{$settings->col_comment}}">
            Ez mindig a komment rész
        </div>
        @endif
        <div class="col order-{{$settings->col_post}}">
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
        
        
        @if ($settings->col_related)
        <div class="col order-{{$settings->col_related}}">
            Ez mindig a related rész
        </div>    
        @endif
        
    </div>
</div>
@endsection
