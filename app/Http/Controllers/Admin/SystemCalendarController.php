<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReservacionsRequest;
use Carbon\Carbon;
use DB;

class SystemCalendarController extends Controller
{
    public function index() 
    {



       $ubs = DB::connection('odbc')->select("SELECT a.id, a.nombre, a.ciudad, a.estado FROM ubicaciones a ");

        foreach ($ubs as $ub ) {
            $rooms[$ub->id] = DB::connection('odbc')->select("SELECT a.id, a.id_ubicacion, a.nombre_seccion FROM seccions a WHERE a.id_ubicacion = ".$ub->id." "); 
        }



        $events = []; 

        foreach (\App\Reservacion::all() as $reservacion) { 
           $crudFieldValue = $reservacion->getOriginal('fecha_de_inicio'); 

           if (! $crudFieldValue) {
               continue;
           }

           $eventLabel     = $reservacion->nombre_de_reunion; 
           $prefix         = 'Reservaciones'; 
           $suffix         = 'Fecha de reservación'; 
           $dataFieldValue = trim($prefix . " " . $eventLabel . " " . $suffix); 
           $events[]       = [ 
                'title' => $dataFieldValue, 
                'start' => $crudFieldValue, 
                'url'   => route('admin.reservacions.edit', $reservacion->id)
           ]; 
        } 


       return view('admin.calendar')->with('events', $events)->with('ubs', $ubs)->with('rooms', $rooms);
    }

}
