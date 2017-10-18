<?php

namespace App\Http\Controllers\Admin;

use App\Ubicacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUbicacionesRequest;
use App\Http\Requests\Admin\UpdateUbicacionesRequest;
use DB;
use Auth;

class UbicacionesController extends Controller
{
    /**
     * Display a listing of Ubicacione.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('ubicacione_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('ubicacione_delete')) {
                return abort(401);
            }
            $ubicaciones = Ubicacione::onlyTrashed()->get();
        } else {
        

        $ubicaciones= DB::connection('odbc')->select('SELECT a.id, a.nombre, a.ciudad, a.estado, a.created_at FROM ubicaciones a'); 

        }

        return view('admin.ubicaciones.index')->with('ubicaciones', $ubicaciones);
    }

    /**
     * Show the form for creating new Ubicacione.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('ubicacione_create')) {
            return abort(401);
        }


        $ubicaciones= DB::connection('odbc')->selectOne('SELECT a.nombre FROM ubicaciones a'); 

        return view('admin.ubicaciones.create')->with('ubicaciones', $ubicaciones);
    }

    /**
     * Store a newly created Ubicacione in storage.
     *
     * @param  \App\Http\Requests\StoreUbicacionesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUbicacionesRequest $request)
    {
        if (! Gate::allows('ubicacione_create')) {
            return abort(401);
        }
        
        $query = "INSERT INTO ubicaciones ( 
            nombre
            , ciudad
            , estado
            , created_at) 
            VALUES ( 
            ".$request->nombre."
            , ".$request->ciudad."
            , ".$request->estado."
            , getdate() )";



        return redirect()->route('admin.ubicaciones.index');
    }


    /**
     * Show the form for editing Ubicacione.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('ubicacione_edit')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::findOrFail($id);

        return view('admin.ubicaciones.edit', compact('ubicacione'));
    }

    /**
     * Update Ubicacione in storage.
     *
     * @param  \App\Http\Requests\UpdateUbicacionesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUbicacionesRequest $request, $id)
    {
        if (! Gate::allows('ubicacione_edit')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::findOrFail($id);
        $ubicacione->update($request->all());



        return redirect()->route('admin.ubicaciones.index');
    }


    /**
     * Display Ubicacione.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('ubicacione_view')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::findOrFail($id);

        return view('admin.ubicaciones.show', compact('ubicacione'));
    }


    /**
     * Remove Ubicacione from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('ubicacione_delete')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::findOrFail($id);
        $ubicacione->delete();

        return redirect()->route('admin.ubicaciones.index');
    }

    /**
     * Delete all selected Ubicacione at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('ubicacione_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Ubicacione::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Ubicacione from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('ubicacione_delete')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::onlyTrashed()->findOrFail($id);
        $ubicacione->restore();

        return redirect()->route('admin.ubicaciones.index');
    }

    /**
     * Permanently delete Ubicacione from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('ubicacione_delete')) {
            return abort(401);
        }
        $ubicacione = Ubicacione::onlyTrashed()->findOrFail($id);
        $ubicacione->forceDelete();

        return redirect()->route('admin.ubicaciones.index');
    }
}
