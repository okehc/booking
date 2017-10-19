@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.users.title')</h3>
    
    {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.users.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('apellido_paterno', trans('quickadmin.users.fields.apellido-paterno').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('apellido_paterno', old('apellido_paterno'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('apellido_paterno'))
                        <p class="help-block">
                            {{ $errors->first('apellido_paterno') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('apellido_materno', trans('quickadmin.users.fields.apellido-materno').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('apellido_materno', old('apellido_materno'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('apellido_materno'))
                        <p class="help-block">
                            {{ $errors->first('apellido_materno') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('ubicacion', trans('quickadmin.users.fields.ubicacion').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('ubicacion', old('ubicacion'), ['class' => 'form-control', 'placeholder' => 'Ubicación del usuario', 'required' => '']) !!}
                    <p class="help-block">Ubicación del usuario</p>
                    @if($errors->has('ubicacion'))
                        <p class="help-block">
                            {{ $errors->first('ubicacion') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('departamento', trans('quickadmin.users.fields.departamento').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('departamento', old('departamento'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('departamento'))
                        <p class="help-block">
                            {{ $errors->first('departamento') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('extension', trans('quickadmin.users.fields.extension').'', ['class' => 'control-label']) !!}
                    {!! Form::text('extension', old('extension'), ['class' => 'form-control', 'placeholder' => 'Extensión de usuario']) !!}
                    <p class="help-block">Extensión de usuario</p>
                    @if($errors->has('extension'))
                        <p class="help-block">
                            {{ $errors->first('extension') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('email', trans('quickadmin.users.fields.email').'*', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('password', trans('quickadmin.users.fields.password').'*', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('role_id', trans('quickadmin.users.fields.role').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('role_id'))
                        <p class="help-block">
                            {{ $errors->first('role_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row" id="div_acceso">
                <div class="col-xs-12 form-group">
                    {!! Form::label('acceso', trans('quickadmin.users.fields.acceso').'*', ['class' => 'control-label']) !!}


                    @foreach($ubicaciones as $ub)
                    <select name="acceso" id="{{ $ub->id }}" class="options"> 
                        @foreach($accesos[$ub->id] as $acceso)
                            <option value="{{ $acceso->id }}">{{ $acceso->nombre_acceso}}</option>
                        @endforeach
                    </select>
                    @endforeach




                </div>
            </div>              
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

