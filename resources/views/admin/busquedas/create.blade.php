@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.busquedas.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.busquedas.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('fehca', trans('quickadmin.busquedas.fields.fehca').'', ['class' => 'control-label']) !!}
                    {!! Form::text('fehca', old('fehca'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fehca'))
                        <p class="help-block">
                            {{ $errors->first('fehca') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('ubicacion', trans('quickadmin.busquedas.fields.ubicacion').'', ['class' => 'control-label']) !!}
                    {!! Form::text('ubicacion', old('ubicacion'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('ubicacion'))
                        <p class="help-block">
                            {{ $errors->first('ubicacion') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('no_personas', trans('quickadmin.busquedas.fields.no-personas').'', ['class' => 'control-label']) !!}
                    {!! Form::text('no_personas', old('no_personas'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('no_personas'))
                        <p class="help-block">
                            {{ $errors->first('no_personas') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop


                