<?php

namespace App\Http\Controllers\Admin;

use App\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSeccionsRequest;
use App\Http\Requests\Admin\UpdateSeccionsRequest;

class SeccionsController extends Controller
{
    /**
     * Display a listing of Seccion.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('seccion_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('seccion_delete')) {
                return abort(401);
            }
            $seccions = Seccion::onlyTrashed()->get();
        } else {
            $seccions = Seccion::all();
        }

        return view('admin.seccions.index', compact('seccions'));
    }

    /**
     * Show the form for creating new Seccion.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('seccion_create')) {
            return abort(401);
        }
        return view('admin.seccions.create');
    }

    /**
     * Store a newly created Seccion in storage.
     *
     * @param  \App\Http\Requests\StoreSeccionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeccionsRequest $request)
    {
        if (! Gate::allows('seccion_create')) {
            return abort(401);
        }
        $seccion = Seccion::create($request->all());



        return redirect()->route('admin.seccions.index');
    }


    /**
     * Show the form for editing Seccion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('seccion_edit')) {
            return abort(401);
        }
        $seccion = Seccion::findOrFail($id);

        return view('admin.seccions.edit', compact('seccion'));
    }

    /**
     * Update Seccion in storage.
     *
     * @param  \App\Http\Requests\UpdateSeccionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeccionsRequest $request, $id)
    {
        if (! Gate::allows('seccion_edit')) {
            return abort(401);
        }
        $seccion = Seccion::findOrFail($id);
        $seccion->update($request->all());



        return redirect()->route('admin.seccions.index');
    }


    /**
     * Display Seccion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('seccion_view')) {
            return abort(401);
        }
        $seccion = Seccion::findOrFail($id);

        return view('admin.seccions.show', compact('seccion'));
    }


    /**
     * Remove Seccion from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('seccion_delete')) {
            return abort(401);
        }
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('admin.seccions.index');
    }

    /**
     * Delete all selected Seccion at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('seccion_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Seccion::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Seccion from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('seccion_delete')) {
            return abort(401);
        }
        $seccion = Seccion::onlyTrashed()->findOrFail($id);
        $seccion->restore();

        return redirect()->route('admin.seccions.index');
    }

    /**
     * Permanently delete Seccion from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('seccion_delete')) {
            return abort(401);
        }
        $seccion = Seccion::onlyTrashed()->findOrFail($id);
        $seccion->forceDelete();

        return redirect()->route('admin.seccions.index');
    }
}