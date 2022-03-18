@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if ($settings->col_comment)
        <div class="col-3 order-{{$settings->col_comment}}">
            @foreach ($comments as $item)
            <div class="card mb-4">
                <div class="card-body">
                    {{$item->body}}
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <div class="@if($settings->col_count == 1)
            col-12
            @elseif($settings->col_count == 2)
            col-9
            @elseif($settings->col_count == 3)
            col-6
            @endif
             order-{{$settings->col_post}}">
             <div class="card mb-4">
                <div class="card-header">
                    {{$post->title}}
                </div>
                <div class="card-body">
                    {{$post->body}}
                </div>
            </div>
            
        </div>
        
        
        @if ($settings->col_related)
        <div class="col-3 order-{{$settings->col_related}}">
            Ez mindig a related rész
        </div>    
        @endif
        
    </div>
</div>
@endsection
