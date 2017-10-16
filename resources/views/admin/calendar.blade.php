@extends('layouts.app')


@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>

    <h3 class="page-title">Calendario</h3>

                    {!! Form::label('ubicacion', trans('quickadmin.reservacion.fields.ubicacion').'', ['class' => 'control-label']) !!}
                    <select name="ubicacion" id="ubicacion">
                        <option value="{{ $ub_default->id }}" SELECTED>{{ $ub_default->nombre}} - {{ $ub_default->ciudad}} - {{ $ub_default->estado}}</option>

                        @foreach($ubs as $ub)
                            <option value="{{ $ub->id }}">{{ $ub->nombre}} - {{ $ub->ciudad}} - {{ $ub->estado}}</option>
                        @endforeach
                          <option value="0">Todas</option>
                    </select>

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

            $('#ubicacion').change( function(){

                var BB = "http://10.30.42.27/booking/public/admin/calendar?ub="+$(this).val();
                alert(BB);
                var events = {
                    url: BB,
                    type: 'POST',
                    data: {
                        ub: $(this).val()
                    }
                }
                alert(events);

            $('#calendar').fullCalendar( 'removeEventSource', events);
            $('#calendar').fullCalendar( 'addEventSource', events);         
            $('#calendar').fullCalendar( 'refetchEvents' );
        }).change();

            var calendar = $('#calendar').fullCalendar({
                editable: true, 
                header: {    
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
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