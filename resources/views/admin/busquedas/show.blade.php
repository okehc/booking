@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.busquedas.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.busquedas.fields.fehca')</th>
                            <td field-key='fehca'>{{ $busqueda->fehca }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.busquedas.fields.ubicacion')</th>
                            <td field-key='ubicacion'>{{ $busqueda->ubicacion }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.busquedas.fields.no-personas')</th>
                            <td field-key='no_personas'>{{ $busqueda->no_personas }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.busquedas.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

                