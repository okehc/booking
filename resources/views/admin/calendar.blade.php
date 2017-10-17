@extends('layouts.app')


@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>

<input type="hidden" name="ubicacion_cal" id="ubicacion_cal" value="<?php echo $ub_id; ?>">

    <h3 class="page-title">Calendario</h3>

                    {!! Form::label('ubicacion', trans('quickadmin.reservacion.fields.ubicacion').'', ['class' => 'control-label']) !!}
                    <select name="ubicacion" id="ubicacion">
                        <option value="{{ $ub_default->id }}" SELECTED>{{ $ub_default->nombre}} - {{ $ub_default->ciudad}} - {{ $ub_default->estado}}</option>

                        @foreach($ubs as $ub)
                            <option value="{{ $ub->id }}">{{ $ub->nombre}} - {{ $ub->ciudad}} - {{ $ub->estado}}</option>
                        @endforeach
                    </select>


                    <input type='button' value='Buscar' id='searchButton' class='btn btn-success'>

    <div id='calendar'></div>

@endsection

@section('javascript')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script src="{{ url('quickadmin/js/locale') }}/es.js" ></script>

   <script>
    $(function() { 

        $('.options').hide();
        var x = document.getElementById("ubicacion").value;
        $('#' + x).show(); 
        $('#ubicacion').change(function(){
            $('.options').hide();
            $('#' + $(this).val()).show();
        });
    });

    </script>


    <script>






        $(document).ready(function () {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear(); 
            var ub_id = $('#ubicacion_cal').val();
            var uurl = "http://10.30.42.27/booking/public/admin/evento?ub="+ub_id;
            alert(uurl);


            $('#searchButton').click(function() {

                var ubicacion = $('#ubicacion').val();
                
//                alert(ubicacion);
//                alert(sala);
                window.location = "http://10.30.42.27/booking/public/admin/calendar?ub="+ubicacion;

            });


            

            var calendar = $('#calendar').fullCalendar({
                editable: true, 
                header: {    
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                events: {
                    //para obtener los resultados del controlador y mostrarlos en el calendario
                    //basta con hacer referencia a la url que nos da dicho resultado, en el ejemplo
                    //en la propiedad url de events ponemos el enlace
                    //y listo eso es todo ya el plugin se encargara de acomodar los eventos
                    //segun la fecha.
                    url:uurl
                },

                eventClick: function(calEvent, jsEvent, view) {
                    alert('Event: ' + calEvent.title);
                    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                    alert('View: ' + view.name);

                    // change the border color just for fun
                    $(this).css('border-color', 'red');

                },
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    window.location = "http://10.30.42.27/booking/public/admin/reservacions/create?start="+start+"&end="+end;
                },
                editable: true,
                selectable: true,
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                        }
                   });
                },

                eventResize: function(event) {      
                    var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                        }
                    });
                }
            });
    });
    </script>
@endsection