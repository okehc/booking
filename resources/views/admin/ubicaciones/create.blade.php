@extends('layouts.app')



<?php var_dump($ubicaciones); ?>

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

                    <input type="text" name="nombre" class="nombre" placeholder="Nombre para identificar la ubicación" id="nombre">

                    <p class="help-block">Nombre para identificar la ubicación</p>
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

