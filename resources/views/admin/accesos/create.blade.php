@extends('layouts.app')
@section('javascript')
<script>

$(document).ready(function() {
    
    $('#nombre_acceso').change(function(){ 

        var id_ub = $('#id_ubicacion').val();
        
        var tmp_name = $('#nombre_acceso').val();

        var stored = $('#json_val').val();
        
        var obj = JSON.parse(stored);

        $('#nombre_acceso').css('border-color','gray');
        $('#help_nombre').css('color', 'gray');
        $('#help_nombre').text('Disponible.');
        $.each(obj, function() {
            $.each(this, function(k, v) {
                
                if(id_ub == k){
                    if(v == tmp_name){
                    alert('Ya existe el nombre para esta ubicacion.');
                    $('#help_nombre').text('Ya existe el nombre para esta ubicación.');
                    $('#nombre_acceso').css('border-color','red');
                    $('#help_nombre').css('color', 'red');
                    }
                }
            });
        });



    });
});




</script>
@endsection


<?php 


$result = array();
foreach ($n_accesos as $n_acceso) {

            $data = array(
             $n_acceso->id_ubicacion    =>    $n_acceso->nombre_acceso,        
         );
         array_push($result,$data);
}

echo "<input type='text' name='json_val' id='json_val' class='json_val' value='".json_encode($result)."'>"; 

?>
@section('content')
    <h3 class="page-title">@lang('quickadmin.accesos.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.accesos.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nombre_acceso', trans('quickadmin.accesos.fields.nombre-acceso').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nombre_acceso', old('nombre_acceso'), ['class' => 'form-control',  'required' => '']) !!}            
                    <p class="help-block" id="help_nombre" class="help_nombre"></p>
                    @if($errors->has('nombre_acceso'))
                        <p class="help-block">
                            {{ $errors->first('nombre_acceso') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('id_ubicacion', trans('quickadmin.accesos.fields.id-ubicacion').'*', ['class' => 'control-label']) !!}
                    <select name="id_ubicacion" id="id_ubicacion">
                        @foreach($ubicaciones as $ubicacion)
                         <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre}} - {{ $ubicacion->estado}}</option>
                        @endforeach
                    </select>

                    <p class="help-block">Ubicación a la que pertenece</p>
                    @if($errors->has('id_ubicacion'))
                        <p class="help-block">
                            {{ $errors->first('id_ubicacion') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

