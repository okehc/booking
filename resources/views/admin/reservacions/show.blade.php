@extends('layouts.app')
@section('javascript')

 <!-- include libraries(jQuery, bootstrap) -->
 <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
 <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
 <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 

 <!-- include summernote css/js-->
 <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
 <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
 

 <script src="{!!asset('/assets/dist/summernote.css')!!}"></script>
 <script src="{!!asset('/assets/dist/summernote.min.js')!!}"></script>
  
@endsection
@section('content')
    <h3 class="page-title">@lang('quickadmin.reservacion.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.nombre-de-reunion')</th>
                            <td field-key='nombre_de_reunion'>{{ $reservacion->nombre_reunion }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.ubicacion')</th>
                            <td field-key='ubicacion'>{{ $reservacion->ubicacion }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.sala-de-juntas')</th>
                            <td field-key='sala_de_juntas'>{{ $reservacion->sala_de_juntas }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.hora-duracion')</th>
                            <td field-key='hora_duracion'>{{ $reservacion->fDate }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.minuto-duracion')</th>
                            <td field-key='minuto_duracion'>{{ $reservacion->sTime }} - {{ $end_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.guest')</th>

                            @foreach ($invitados as $invitado)
                                <td field-key='repeat'>{{ $invitado->nombre }} {{ $invitado->apellido }}. {{ $invitado->email }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.reservacion.fields.comentario')</th>
                            <td field-key='comentario'>{!! $reservacion->comentario !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>


            <div class="box-body">
                <div class="form-group">
                    {{Form::label('title', 'Minuta')}}
                 </div>
            <div class="form-group">
            </div>
            <div id="summernote"></div>
            <script>
                 $('#summernote').summernote({
                   placeholder: 'Hello bootstrap 4',
                   tabsize: 2,
                   height: 100
                 });
            </script>
            <div class="form-group">
                {{Form::submit('Enviar Minuta',array('class' => 'btn btn-primary btn-sm'))}} </div>

            <a href="{{ route('admin.reservacions.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
