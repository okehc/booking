<?php

namespace App\Http\Controllers\Admin;

use App\Busqueda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBusquedasRequest;
use App\Http\Requests\Admin\UpdateBusquedasRequest;
use Auth;
use DB;

class BusquedasController extends Controller
{
    /**
     * Display a listing of Busqueda.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('busqueda_access')) {
            return abort(401);
        }

        $ubs = DB::connection('odbc')->select("SELECT a.id, a.nombre, a.ciudad, a.estado FROM ubicaciones a ");

        return view('admin.busquedas.index')->with('ubs', $ubs);
    }

    /**
     * Show the form for creating new Busqueda.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('busqueda_create')) {
            return abort(401);
        }
        return view('admin.busquedas.create');
    }

    /**
     * Store a newly created Busqueda in storage.
     *
     * @param  \App\Http\Requests\StoreBusquedasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusquedasRequest $request)
    {
        if (! Gate::allows('busqueda_create')) {
            return abort(401);
        }
        $date = $request->date;
        $dd=explode('/', $date);
        $real_date = $dd[2]."/".$dd[1]."/".$dd[0];
        $no_personas = isset($request->no_personas) ? $request->no_personas : 0;
        $ubicacion = $request->ubicacion;


        $salas= DB::connection('odbc')->select("SELECT * FROM seccions a WHERE a.id_ubicacion = ".$ubicacion." ");


        foreach ($salas as $sala) {
            
            $libres[] = DB::connection('odbc')->select(" 
                SELECT a.* FROM seccions a 
                WHERE a.id NOT IN (SELECT b.id_seccion 
                                   FROM reservaciones b 
                                   WHERE b.fecha_inicio ='".$real_date."') ");
        }

        return view('admin.busquedas.show')->with('libres', $libres);
    }


    /**
     * Display Busqueda.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('busqueda_view')) {
            return abort(401);
        }
        $busqueda = Busqueda::findOrFail($id);

        return view('admin.busquedas.show', compact('busqueda'));
    }

}

                