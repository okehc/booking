@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')


@section('javascript')

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('datePicker/css/bootstrap-standalone.css')}}">
    <script src="{{asset('datePicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Languaje -->
    <script src="{{asset('datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
 
       <link rel="stylesheet" href="{{asset('picker/jquery.timepicker.css')}}">
    <script src="{{asset('picker/jquery.timepicker.js')}}"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.js"></script>
@endsection    

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
                <tbody>
                    <tr>
                        <td>@lang('quickadmin.busquedas.fields.fehca')</td>
                        <td><input type="text" class="form-control datepicker" name="date"></td>
                    </tr>
                    <tr>
                        <td>@lang('quickadmin.busquedas.fields.ubicacion')</td>
                        <td><select name="ubicacion" id="ubicacion">
                            @foreach($ubs as $ub)
                                <option value="{{ $ub->id }}">{{ $ub->nombre}} - {{ $ub->ciudad}} - {{ $ub->estado}}</option>
                            @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('quickadmin.busquedas.fields.no-personas')</td>
                        <td>
                            {!! Form::text('no_personas', old('no_personas'), ['class' => 'form-control', 'placeholder' => 'No. invitados', 'required' => '']) !!}

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
@stop

@section('javascript') 
    <script>
        
    </script>
@endsection

                