<?php

namespace App\Http\Controllers\Admin;

use App\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReservacionsRequest;
use App\Http\Requests\Admin\UpdateReservacionsRequest;
use DB;
use Auth;

class ReservacionsController extends Controller
{


    public function addDayswithdate($date,$days, $endDate, &$finalResult){
        $tempDate = strtotime($date);   
        $tempDate += 3600*24*$days;
        if ($tempDate < strtotime($endDate)) {
            $finalResult[] = date("Y-m-d", $tempDate);
            $this->addDayswithdate(date("Y-m-d", $tempDate), $days, $endDate, $finalResult);
        } else {
            return true;        
        }
    }







    /**
     * Display a listing of Reservacion.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('reservacion_access')) {
            return abort(401);
        }

        $userId = Auth::id();

        if (request('show_deleted') == 1) {
            if (! Gate::allows('reservacion_delete')) {
                return abort(401);
            }
            $reservacions = Reservacion::onlyTrashed()->get();
        } else {
            #$reservacions = Reservacion::all();
            $reservacions= DB::connection('odbc')->select("SELECT a.id, a.nombre_reunion, b.nombre as ubicacion, c.nombre_seccion as sala_de_juntas, a.fecha_inicio as hora_duracion, a.hora_inicio as minuto_duracion, a.tiempo_duracion as tiempo FROM reservaciones a JOIN ubicaciones b ON a.id_ubicacion = b.id JOIN seccions c ON a.id_seccion = c.id WHERE id_usuario = ".$userId." AND a.fecha_inicio >= getdate() ORDER BY a.fecha_inicio DESC");

             $old_reservacions= DB::connection('odbc')->select("SELECT a.id, a.nombre_reunion, b.nombre as ubicacion, c.nombre_seccion as sala_de_juntas, a.fecha_inicio as hora_duracion, a.hora_inicio as minuto_duracion, a.tiempo_duracion as tiempo FROM reservaciones a JOIN ubicaciones b ON a.id_ubicacion = b.id JOIN seccions c ON a.id_seccion = c.id WHERE id_usuario = ".$userId." AND a.fecha_inicio < getdate() ORDER BY a.fecha_inicio DESC");
         
        }

        return view('admin.reservacions.index')->with('reservacions', $reservacions)->with('old_reservacions', $old_reservacions);
    }

    /**
     * Show the form for creating new Reservacion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('reservacion_create')) {
            return abort(401);
        }

        $userId = Auth::id();
        $ub = isset($_GET['ub']) ? $_GET['ub'] : 0;

        $ub_default= DB::connection('odbc')->selectOne("SELECT a.id, a.nombre, a.ciudad, a.estado FROM ubicaciones a JOIN users b ON a.id = b.ubicacion WHERE b.id = ".$userId." ");

        $ubs = DB::connection('odbc')->select("SELECT a.id, a.nombre, a.ciudad, a.estado FROM ubicaciones a ");

        foreach ($ubs as $ub ) {
            $rooms[$ub->id] = DB::connection('odbc')->select("SELECT a.id, a.id_ubicacion, a.nombre_seccion FROM seccions a WHERE a.id_ubicacion = ".$ub->id." "); 
        }


        $items = DB::connection('odbc')->select("SELECT a.id_seccions, a.id_item FROM items_seccions a ");

        foreach ($items as $item ) {
            $room_items[$item->id_seccions] = DB::connection('odbc')->select("SELECT a.item_nombre, a.item_descripcion FROM items a WHERE a.id = ".$item->id_item." "); 
        }

        return view('admin.reservacions.create')->with('ub_default', $ub_default)->with('ubs', $ubs)->with('rooms', $rooms)->with('room_items', $room_items)->with('items', $items)->with('ub_from_calendar', $ub);
    }



    /**
     * Store a newly created Reservacion in storage.
     *
     * @param  \App\Http\Requests\StoreReservacionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservacionsRequest $request)
    {
        if (! Gate::allows('reservacion_create')) {
            return abort(401);
        }

        #ar_dump($request); echo "<br>";
        #$request = $this->saveFiles($request);

        $userId = Auth::id();


        $f_inicio = $request->date;
        $f_ini2 = explode('/', $f_inicio);
        $f_ini3 = $f_ini2[2]."-".$f_ini2[1]."-".$f_ini2[0]; 

        $h_inicio = date('H:i:s', strtotime($request->hora_inicio));
        $h_duracion = date('H:i:s', strtotime($request->horas));
        $id_seccion = $request->sala_de_juntas;
        $repeat  = ($request->repeat == 1) ? 1 : 0 ;
   
        # validate if date is selected 
        $val_reservation= DB::connection('odbc')->select("SELECT id, fecha_inicio, hora_inicio, tiempo_duracion FROM reservaciones WHERE id_seccion = ".$request->sala_de_juntas." AND fecha_inicio = '".$f_ini3."' ");

        foreach ($val_reservation as $key ) {
            $tiempo_final = $key->hora_inicio + $key->tiempo_duracion;
            if ($h_inicio >= $key->hora_inicio && $h_inicio < $tiempo_final) {
                $validation[] = $key->id; 
            }
        }

        if ( !empty($validation) ) {
            $error = "Hora y Sala ya han sido reservadas, elija otra hora";
            #return redirect()->route('admin.reservacions.create')->with('error', $error);    
            echo "nononono";
            exit();
        } else {

            $reservation = DB::connection('odbc')->insert("INSERT INTO reservaciones (created_at, nombre_reunion, id_ubicacion, id_seccion, fecha_inicio, hora_inicio, tiempo_duracion, message, repeat, id_usuario) VALUES (getdate(), '".$request->nombre_de_reunion."', ".$request->ubicacion.", ".$request->sala_de_juntas.", '".$f_ini3."', '".$h_inicio."', '".$h_duracion."', '".$request->comentario."', ".$repeat.", ".$userId.")");

            $last_id = DB::connection('odbc')->selectOne("SELECT id FROM reservaciones WHERE message ='".$request->comentario."' AND  fecha_inicio ='".$f_ini3."' AND hora_inicio = '".$h_inicio."' ");

            $guest_count = (count($request->guest_name));

            for ($i=0; $i < $guest_count; $i++) { 
                
                 DB::connection('odbc')->insert("INSERT INTO invitados (id_reservacion, nombre, apellido, email, created_at) VALUES (".$last_id->id.", '".$request->guest_name[$i]."', '".$request->guest_last[$i]."', '".$request->guest_email[$i]."', getdate()) ");
            }

            if( $repeat == 1 ) {

                if( $request->concurrencia == 1 ) {

                    # -1 cada n dias, -2 cada día de la semana
                    $repeticion = $request->repeticion;
                    $rep_end = $request->rep_end;
                    if ($rep_end == 2) { 
                        $dateEnd = $request->end_date; 
                        $dateEnd2 = explode('/', $dateEnd);
                        $dateEnd3 = $dateEnd2[2]."-".$dateEnd2[1]."-".$dateEnd2[0];
                    } else {
                        $dateEnd3 = date("Y-m-d", strtotime($f_ini3. " +2 years"));
                    }

                    # repeticion cada N dias
                    if ($repeticion == 1) {

                        $startDate = $f_ini3;
                        $endDate = $dateEnd3;
                        $daysBetween = $request->rep_day;
                        $finalResult = array();
                        $this->addDayswithdate($startDate,$daysBetween, $endDate, $finalResult);

                        

                        for ($i=0; $i < count($finalResult); $i++) { 
                            $reservation = DB::connection('odbc')->insert("INSERT INTO reservaciones (created_at, nombre_reunion, id_ubicacion, id_seccion, fecha_inicio, hora_inicio, tiempo_duracion, message, repeat, id_usuario) VALUES (getdate(), '".$request->nombre_de_reunion."', ".$request->ubicacion.", ".$request->sala_de_juntas.", '".$finalResult[$i]."', '".$h_inicio."', '".$h_duracion."', '".$request->comentario."', ".$repeat.", ".$userId.")");
                        }

                    #repeticion diario   
                    } else {

                        $startDate = $f_ini3;
                        $endDate = $dateEnd3;
                        $daysBetween = 1;
                        $finalResult = array();
                        $this->addDayswithdate($startDate,$daysBetween, $endDate, $finalResult);

                        for ($i=0; $i < count($finalResult); $i++) { 
                            $reservation = DB::connection('odbc')->insert("INSERT INTO reservaciones (created_at, nombre_reunion, id_ubicacion, id_seccion, fecha_inicio, hora_inicio, tiempo_duracion, message, repeat, id_usuario) VALUES (getdate(), '".$request->nombre_de_reunion."', ".$request->ubicacion.", ".$request->sala_de_juntas.", '".$finalResult[$i]."', '".$h_inicio."', '".$h_duracion."', '".$request->comentario."', ".$repeat.", ".$userId.")");
                        }
                    }


                } elseif ( $request->concurrencia == 2 ) {
                    
                    $rep_day = $request->rep_day2;
                    $weeekday = $request->weeekday;
                  
                    $rep_end = $request->rep_end2;
                    if ($rep_end == 2) { 
                        $dateEnd = $request->end_date2; 
                        $dateEnd2 = explode('/', $dateEnd);
                        $dateEnd3 = $dateEnd2[2]."-".$dateEnd2[1]."-".$dateEnd2[0];
                    } else {
                        $dateEnd3 = date("Y-m-d", strtotime($f_ini3. " +2 years"));
                    }                    

                    
                    foreach ($weeekday as $key ) {
                        $week[$key] = date('Y-m-d',strtotime("next ".$key.""));

                        $reservation = DB::connection('odbc')->insert("INSERT INTO reservaciones (created_at, nombre_reunion, id_ubicacion, id_seccion, fecha_inicio, hora_inicio, tiempo_duracion, message, repeat, id_usuario) VALUES (getdate(), '".$request->nombre_de_reunion."', ".$request->ubicacion.", ".$request->sala_de_juntas.", '".$week[$key]."', '".$h_inicio."', '".$h_duracion."', '".$request->comentario."', ".$repeat.", ".$userId.")");

                        for($i=0; $i<$rep_day;++$i){  
                            $week[$key] = date('Y-m-d', strtotime($week[$key] . ' +1 Week'));

                            $reservation = DB::connection('odbc')->insert("INSERT INTO reservaciones (created_at, nombre_reunion, id_ubicacion, id_seccion, fecha_inicio, hora_inicio, tiempo_duracion, message, repeat, id_usuario) VALUES (getdate(), '".$request->nombre_de_reunion."', ".$request->ubicacion.", ".$request->sala_de_juntas.", '".$week[$key]."', '".$h_inicio."', '".$h_duracion."', '".$request->comentario."', ".$repeat.", ".$userId.")");

                        }
                    }
                                   

                } elseif ( $request->concurrencia == 3 ) {
                    # code...
                }



            }   

        }

        #$reservacion = Reservacion::create($request->all());
        return redirect()->route('admin.reservacions.index');
    }


    /**
     * Show the form for editing Reservacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('reservacion_edit')) {
            return abort(401);
        }
        $reservacion = Reservacion::findOrFail($id);

        return view('admin.reservacions.edit', compact('reservacion'));
    }

    /**
     * Update Reservacion in storage.
     *
     * @param  \App\Http\Requests\UpdateReservacionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservacionsRequest $request, $id)
    {
        if (! Gate::allows('reservacion_edit')) {
            return abort(401);
        }
        $reservacion = Reservacion::findOrFail($id);
        $reservacion->update($request->all());



        return redirect()->route('admin.reservacions.index');
    }


    /**
     * Display Reservacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('reservacion_view')) {
            return abort(401);
        }
        
        $userId = Auth::id();

        $reservacion= DB::connection('odbc')->selectOne("SELECT a.id, a.nombre_reunion, b.nombre as ubicacion, c.nombre_seccion as sala_de_juntas, a.fecha_inicio as fDate, a.hora_inicio as sTime, a.tiempo_duracion as eTime, a.message as comentario FROM reservaciones a JOIN ubicaciones b ON a.id_ubicacion = b.id JOIN seccions c ON a.id_seccion = c.id WHERE a.id = ".$id." ");

        $secs = strtotime($reservacion->eTime)-strtotime("00:00:00");
        $end_time = date("H:i:s",strtotime($reservacion->sTime)+$secs);

        $invitados = DB::connection('odbc')->select("SELECT a.nombre, a.apellido, a.email FROM invitados a WHERE a.id_reservacion = ".$id." ");
        $minuta = DB::connection('odbc')->SelectOne("SELECT content FROM minutas WHERE id_reservacion=".$id."  ");

        return view('admin.reservacions.show')->with('reservacion', $reservacion)->with('end_time', $end_time)->with('invitados', $invitados)->with('minuta', $minuta);
    }



    public function minuta(StoreReservacionsRequest $request)
    {

        $userId = Auth::id();
        $text = $request->minuta;
        $id_reservation = $request->nombre_de_reunion;

        var_dump($text); echo "<br>"; var_dump($id_reservation);


        $reservacion= DB::connection('odbc')->insert("INSERT INTO minutas (id_reservacion, content, created_at) VALUES (".$id_reservation.", '".$text."', getdate()  )");

        return redirect()->route('admin.reservacions.show', $id_reservation);

    }


    public function search(StoreReservacionsRequest $request)
    {
        var_dump($request);
    }

}
