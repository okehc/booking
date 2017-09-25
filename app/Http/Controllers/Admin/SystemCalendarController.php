<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SystemCalendarController extends Controller
{
    public function index() 
    {
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


       return view('admin.calendar' , compact('events')); 
    }

}
