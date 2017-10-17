@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.busquedas.title')</h3>
    @can('busqueda_create')
    <p>
        <a href="{{ route('admin.busquedas.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($busquedas) > 0 ? 'datatable' : '' }} ">
                <thead>
                    <tr>
                        
                        <th>@lang('quickadmin.busquedas.fields.fehca')</th>
                        <th>@lang('quickadmin.busquedas.fields.ubicacion')</th>
                        <th>@lang('quickadmin.busquedas.fields.no-personas')</th>
                                                <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($busquedas) > 0)
                        @foreach ($busquedas as $busqueda)
                            <tr data-entry-id="{{ $busqueda->id }}">
                                
                                <td field-key='fehca'>{{ $busqueda->fehca }}</td>
                                <td field-key='ubicacion'>{{ $busqueda->ubicacion }}</td>
                                <td field-key='no_personas'>{{ $busqueda->no_personas }}</td>
                                                                <td>
                                    @can('busqueda_view')
                                    <a href="{{ route('admin.busquedas.show',[$busqueda->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">@lang('quickadmin.qa_no_entries_in_table')</td>
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

                