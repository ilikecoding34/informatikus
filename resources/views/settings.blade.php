@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card text-center">
                <form class="form-group" method="POST" action="{{route('save')}}">
                    @csrf
                    @method('POST')
                <div class="card-header">{{ __('Beállítások') }}</div>
                <div class="card-body">

                  <select class="column_count" id="column_count" name="column_count" aria-label="Default select example">
                    @foreach ($column_number_select as $key=>$item)
                        <option value={{$key}}
                        @if($user_settings->column_number == $key)
                            selected
                        @endif>{{$item}}</option>
                    @endforeach
                  </select>
                  <div class="row g-3 pt-2 pb-2">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="col-sm">
                            <select class="column_type" id="column_type_{{ $i }}" name="order_type[]" aria-label="Default select example">
                                @foreach ($column_type_select as $key=>$item)
                                    <option value={{$key}}
                                    @if($user_settings->order_type == $key)
                                        selected
                                    @endif>{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor

                </div>
                <button type="submit" class="btn btn-success">Mentés</button>
            </form>
                </div>

            </div>

            </div>


        </div>
    </div>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
            <div class="col-xl-{{10-(($user_settings->column_number-1)*2)}}
            @if ($user_settings->column_number==2)
            @if ($user_settings->order_type[0] == 2)
                order-first
            @else
                order-last
            @endif
            @endif">
            <div class="card">
            <div class="text-center">
                <span id='middle_column'>
                    Bejegyzés
                </span>
                @for ($i = 1; $i <= 5; $i++)
                    <div>Post: {{$i}}</div>
                @endfor
                </div>
            </div>
            </div>
        @if ($user_settings->column_number==2 || $user_settings->column_number==3)
            <div class="col-xl-3
                @if ($user_settings->column_number==3)
                    order-last
                @endif ">
                <div class="card">
                <div class="text-center">
                <span id='right_column'>
                @if ($user_settings->order_type[0] == 2)
                    @foreach ($column_type_select as $key=>$item)
                    @if($user_settings->order_type[1] == $key)
                        {{$item}}
                    @endif
                    @endforeach
                    @else
                    @foreach ($column_type_select as $key=>$item)
                    @if($user_settings->order_type[0] == $key)
                        {{$item}}
                    @endif
                    @endforeach
                @endif
                </span>
                </div>
                </div>
            </div>
        @endif
        @if ($user_settings->column_number==3)
            <div class="col-xl-3
            @if ($user_settings->column_number==3)
                order-first
            @endif ">
            <div class="card">
            <div class="text-center">
            <span id='left_column'>
                @foreach ($column_type_select as $key=>$item)
                        @if($user_settings->order_type[2] == $key)
                            {{$item}}
                        @endif
                @endforeach
            </span>
            </div>
            </div>
            </div>
        @endif
    </div>

  </div>
</div>
</div>
</div>
</div>

<script>
    $( document ).ready(function() {
    for(let i = {{$user_settings->column_number}}+1; i<= 3; i++){
        $('#column_type_'+i).attr('disabled','disabled');
        $('#column_type_'+i).hide();
    }
    });
    var count;



    $('#column_count').on("change", function() {
        if($(this).val() > 1){
            $('.column_type').removeAttr('disabled');

        }
    if ($(this).val() == 1){
        $('#column_type_1').show();
        $('#column_type_1').val(2);
        $('#column_type_1').attr('disabled','disabled');
        $('#column_type_2').hide();
        $('#column_type_3').hide();
    }
    if ($(this).val() == 2){
        $('#column_type_1').show();
        $('#column_type_1').removeAttr('disabled');
        $('#column_type_2').removeAttr('disabled');
        $('#column_type_2').show();
        $('#column_type_3').hide();
    }
    if ($(this).val() == 3){
        $('#column_type_2').val(2);
        $('#column_type_2').attr('readonly',true);
        $('#column_type_1').show();
        $('#column_type_1').removeAttr('disabled');
        $('#column_type_2').show();
        $('#column_type_3').show();

        $('#column_type_1 option[value=2]').attr('disabled','disabled');
        $('#column_type_3 option[value=2]').attr('disabled','disabled');
    }
        count = $(this).val();
    });

    $('#column_type_1').on("change", function() {
        var value = $(this).val();
        if(value == 1){
            $('#column_type_3').val(3);
        }
        if(value == 1 || value == 3){
            $('#column_type_2').val(2);

        }
        if (value == 2){
            $('#column_type_2').val(0);
            $('#column_type_2 option[value=2]').attr('disabled','disabled');
        }
        if(value == 3){
            $('#column_type_3').val(1);
        }
    });
    $('#column_type_2').on("change", function() {
        var value = $(this).val();
        if(value == 1 || value == 3){
            $('#column_type_1').val(2);
        }
        if (value == 2){
            $('#column_type_1').val(0);
            $('#column_type_1 option[value=2]').attr('disabled','disabled');
        }
    });
    $('#column_type_3').on("change", function() {
        var value = $(this).val();
        if(value == 1){
            $('#column_type_1').val(3);
        }
        if(value == 3){
            $('#column_type_1').val(1);
        }
    });
</script>
@endsection
