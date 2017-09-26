<?php

namespace App\Http\Controllers\Admin;

use App\Ubicacione;
use App\Acceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAccesosRequest;
use App\Http\Requests\Admin\UpdateAccesosRequest;
use DB;

class AccesosController extends Controller
{
    /**
     * Display a listing of Acceso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('acceso_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('acceso_delete')) {
                return abort(401);
            }
            $accesos = Acceso::onlyTrashed()->get();
        } else {
            $accesos = Acceso::all();
        }

        return view('admin.accesos.index', compact('accesos'));
    }

    /**
     * Show the form for creating new Acceso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('acceso_create')) {
            return abort(401);
        }

        try {
            $ubicaciones= DB::connection('mysql')->select('SELECT id, nombre, estado FROM ubicaciones') ;    
            
            foreach($ubicaciones as $ubicacion) {
                $ub_array[$ubicacion->id] = $ubicacion->nombre;
            }

            $ubi= Ubicacione::all();

print_r($ubi);

#print_r($ubicaciones);
#print_r($ub_array);

        } catch (\Exception $ubicaciones) {
            die("Could not connect to the database.  Please check your configuration.");
        }

        return view('admin.accesos.create')->with('ub_array', $ub_array);
    }

    /**
     * Store a newly created Acceso in storage.
     *
     * @param  \App\Http\Requests\StoreAccesosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccesosRequest $request)
    {
        if (! Gate::allows('acceso_create')) {
            return abort(401);
        }
        $acceso = Acceso::create($request->all());



        return redirect()->route('admin.accesos.index');
    }


    /**
     * Show the form for editing Acceso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('acceso_edit')) {
            return abort(401);
        }
        $acceso = Acceso::findOrFail($id);

        return view('admin.accesos.edit', compact('acceso'));
    }

    /**
     * Update Acceso in storage.
     *
     * @param  \App\Http\Requests\UpdateAccesosRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccesosRequest $request, $id)
    {
        if (! Gate::allows('acceso_edit')) {
            return abort(401);
        }
        $acceso = Acceso::findOrFail($id);
        $acceso->update($request->all());



        return redirect()->route('admin.accesos.index');
    }


    /**
     * Display Acceso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('acceso_view')) {
            return abort(401);
        }
        $acceso = Acceso::findOrFail($id);

        return view('admin.accesos.show', compact('acceso'));
    }


    /**
     * Remove Acceso from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('acceso_delete')) {
            return abort(401);
        }
        $acceso = Acceso::findOrFail($id);
        $acceso->delete();

        return redirect()->route('admin.accesos.index');
    }

    /**
     * Delete all selected Acceso at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('acceso_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Acceso::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Acceso from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('acceso_delete')) {
            return abort(401);
        }
        $acceso = Acceso::onlyTrashed()->findOrFail($id);
        $acceso->restore();

        return redirect()->route('admin.accesos.index');
    }

    /**
     * Permanently delete Acceso from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('acceso_delete')) {
            return abort(401);
        }
        $acceso = Acceso::onlyTrashed()->findOrFail($id);
        $acceso->forceDelete();

        return redirect()->route('admin.accesos.index');
    }
}
