@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.seccion.title')</h3>
    
    {!! Form::model($seccion, ['method' => 'PUT', 'route' => ['admin.seccions.update', $seccion->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('id_ubicacion', trans('quickadmin.seccion.fields.id-ubicacion').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('id_ubicacion', old('id_ubicacion'), ['class' => 'form-control', 'placeholder' => 'Ubicación a la que pertenece', 'required' => '']) !!}
                    <p class="help-block">Ubicación a la que pertenece</p>
                    @if($errors->has('id_ubicacion'))
                        <p class="help-block">
                            {{ $errors->first('id_ubicacion') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nombre_seccion', trans('quickadmin.seccion.fields.nombre-seccion').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nombre_seccion', old('nombre_seccion'), ['class' => 'form-control', 'placeholder' => 'Nombre del recurso', 'required' => '']) !!}
                    <p class="help-block">Nombre del recurso</p>
                    @if($errors->has('nombre_seccion'))
                        <p class="help-block">
                            {{ $errors->first('nombre_seccion') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('id_atributos', trans('quickadmin.seccion.fields.id-atributos').'', ['class' => 'control-label']) !!}
                    {!! Form::number('id_atributos', old('id_atributos'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('id_atributos'))
                        <p class="help-block">
                            {{ $errors->first('id_atributos') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
