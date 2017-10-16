<?php
namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Evento;
use Illuminate\Http\Request;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
class EventoController extends Controller
{
    public function index()
    {

    	$ub = $_REQUEST['ub'];

    	$userId = Auth::id();

    	if ($ub == 0) {
				$reservacions= DB::connection('odbc')->select("SELECT 
					a.id, 
					a.nombre_reunion as title, 
					a.fecha_inicio as fecha, 
					a.hora_inicio as time_start, 
					a.tiempo_duracion as time_end, 
					b.name, 
					b.apellido_paterno,
					c.nombre_seccion
					FROM reservaciones a  
					JOIN users b ON a.id_usuario = b.id 
					JOIN  seccions c ON a.id_seccion  = c.id");

						foreach ($reservacions as $key ) {

							$real_title = $key->nombre_seccion.", ".$key->name.", ".$key->apellido_paterno;

							$secs = strtotime($key->time_end)-strtotime("00:00:00");
							$end_time = date("H:i:s",strtotime($key->time_start)+$secs);
							$sTime = date('Y-m-d H:i:s', strtotime("$key->fecha $key->time_start"));
							$eTime = date('Y-m-d H:i:s', strtotime("$key->fecha $end_time"));

							$t[] =  array("title" => $real_title, "start" => $sTime, "end" => $eTime, "url" => "http://10.30.42.27/booking/public/admin/reservacions/".$key->id." ");

						}

 			} else {

		$reservacions= DB::connection('odbc')->select("SELECT 
			a.id, 
			a.nombre_reunion as title, 
			a.fecha_inicio as fecha, 
			a.hora_inicio as time_start, 
			a.tiempo_duracion as time_end, 
			b.name, 
			b.apellido_paterno,
			c.nombre_seccion
			FROM reservaciones a  
			JOIN users b ON a.id_usuario = b.id 
			JOIN  seccions c ON a.id_seccion  = c.id
			where a.id_ubicacion = ".$ub." ");

$t[] =  array("title" => $real_title, "start" => $sTime, "end" => $eTime, "url" => "http://10.30.42.27/booking/public/admin/reservacions/".$key->id." ");


 			}


		return json_encode($t);
        #return response()->json($data); //para luego retornarlo y estar listo para consumirlo
 
    }
}




?>