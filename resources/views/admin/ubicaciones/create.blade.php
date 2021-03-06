@extends('layouts.app')

@section('javascript')
<script>

$(document).ready(function() {
    
    $('#nombre').change(function(){ 

        var stored_name = $('#json_name').val();
        var tmp_name = $('#nombre').val();
        var obj = JSON.parse(stored_name);

        $(':input[type="submit"]').prop('disabled', false)
        $('#nombre').css('border-color','gray');
        $('nombre_status').css('color', 'gray');
        $('#nombre_status').text('Disponible.');
        $.each(obj, function() {
            $.each(this, function(k, v) {
                
                if(v == tmp_name) {
                    alert('Ya existe el nombre.');
                    $('#nombre_status').text('Ya existe el nombre.');
                    $('#nombre').css('border-color','red');
                    $('nombre_status').css('color', 'red');
                    $(':input[type="submit"]').prop('disabled', true)
                } 
            });
        });



    });
});




</script>
@endsection


<?php 


$result = array();
foreach ($ubicaciones as $ub) {

            $data = array(
             'name'    =>    $ub->nombre,        
         );
         array_push($result,$data);
}

echo "<input type='hidden' name='json_name' id='json_name' class='json_name' value='".json_encode($result)."'>"; 

?>

@section('content')
    <h3 class="page-title">@lang('quickadmin.ubicaciones.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.ubicaciones.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nombre', trans('quickadmin.ubicaciones.fields.nombre').'*', ['class' => 'control-label']) !!}

                    <input type="text" name="nombre" class="form-control" placeholder="Nombre para identificar la ubicación" id="nombre">


                    <p class="help-block" id="nombre_status" ></p>
                    @if($errors->has('nombre'))
                        <p class="help-block">
                            {{ $errors->first('nombre') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('ciudad', trans('quickadmin.ubicaciones.fields.ciudad').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('ciudad', old('ciudad'), ['class' => 'form-control', 'placeholder' => 'Ciudad de la Ubicación', 'required' => '']) !!}
                    <p class="help-block">Ciudad de la Ubicación</p>
                    @if($errors->has('ciudad'))
                        <p class="help-block">
                            {{ $errors->first('ciudad') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('estado', trans('quickadmin.ubicaciones.fields.estado').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('estado', old('estado'), ['class' => 'form-control', 'placeholder' => 'Estado de la Ubicación', 'required' => '']) !!}
                    <p class="help-block">Estado de la Ubicación</p>
                    @if($errors->has('estado'))
                        <p class="help-block">
                            {{ $errors->first('estado') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

