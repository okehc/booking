@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.reservacion.title')</h3>
    @can('reservacion_create')
    <p>
        <a href="{{ route('admin.reservacions.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($reservacions) > 0 ? 'datatable' : '' }} ">
                <thead>
                    <tr>
                        
                        <th>@lang('quickadmin.reservacion.fields.nombre-de-reunion')</th>
                        <th>@lang('quickadmin.reservacion.fields.ubicacion')</th>
                        <th>@lang('quickadmin.reservacion.fields.sala-de-juntas')</th>
                        <th>@lang('quickadmin.reservacion.fields.fecha-de-inicio')</th>
                        <th>@lang('quickadmin.reservacion.fields.fecha-de-finalizacion')</th>
                        <th>@lang('quickadmin.reservacion.fields.repeat')</th>
                        <th>@lang('quickadmin.reservacion.fields.invitado')</th>
                        <th>@lang('quickadmin.reservacion.fields.comentario')</th>
                                                <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($reservacions) > 0)
                        @foreach ($reservacions as $reservacion)
                            <tr data-entry-id="{{ $reservacion->id }}">
                                
                                <td field-key='nombre_de_reunion'>{{ $reservacion->nombre_de_reunion }}</td>
                                <td field-key='ubicacion'>{{ $reservacion->ubicacion }}</td>
                                <td field-key='sala_de_juntas'>{{ $reservacion->sala_de_juntas }}</td>
                                <td field-key='fecha_de_inicio'>{{ $reservacion->fecha_de_inicio }}</td>
                                <td field-key='fecha_de_finalizacion'>{{ $reservacion->fecha_de_finalizacion }}</td>
                                <td field-key='repeat'>{{ Form::checkbox("repeat", 1, $reservacion->repeat == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='invitado'>{!! $reservacion->invitado !!}</td>
                                <td field-key='comentario'>{!! $reservacion->comentario !!}</td>
                                                                <td>
                                    @can('reservacion_view')
                                    <a href="{{ route('admin.reservacions.show',[$reservacion->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('reservacion_edit')
                                    <a href="{{ route('admin.reservacions.edit',[$reservacion->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        
    </script>
@endsection