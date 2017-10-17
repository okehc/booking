<?php

namespace App\Http\Controllers\Admin;

use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDepartamentosRequest;
use App\Http\Requests\Admin\UpdateDepartamentosRequest;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of Departamento.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('departamento_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('departamento_delete')) {
                return abort(401);
            }
            $departamentos = Departamento::onlyTrashed()->get();
        } else {
            $departamentos = Departamento::all();
        }

        return view('admin.departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating new Departamento.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('departamento_create')) {
            return abort(401);
        }
        return view('admin.departamentos.create');
    }

    /**
     * Store a newly created Departamento in storage.
     *
     * @param  \App\Http\Requests\StoreDepartamentosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartamentosRequest $request)
    {
        if (! Gate::allows('departamento_create')) {
            return abort(401);
        }
        $query = "INSERT INTO departamentos ( 
            departamento
            , descripcion
            , created_at) 
            VALUES ( 
            ".$request->departamento."
            , ".$request->descripcion."
            , getdate() )";



        return redirect()->route('admin.departamentos.index');
    }


    /**
     * Show the form for editing Departamento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('departamento_edit')) {
            return abort(401);
        }
        $departamento = Departamento::findOrFail($id);

        return view('admin.departamentos.edit', compact('departamento'));
    }

    /**
     * Update Departamento in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartamentosRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartamentosRequest $request, $id)
    {
        if (! Gate::allows('departamento_edit')) {
            return abort(401);
        }
        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());



        return redirect()->route('admin.departamentos.index');
    }


    /**
     * Display Departamento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('departamento_view')) {
            return abort(401);
        }
        $departamento = Departamento::findOrFail($id);

        return view('admin.departamentos.show', compact('departamento'));
    }


    /**
     * Remove Departamento from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('departamento_delete')) {
            return abort(401);
        }
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('admin.departamentos.index');
    }

    /**
     * Delete all selected Departamento at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('departamento_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Departamento::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Departamento from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('departamento_delete')) {
            return abort(401);
        }
        $departamento = Departamento::onlyTrashed()->findOrFail($id);
        $departamento->restore();

        return redirect()->route('admin.departamentos.index');
    }

    /**
     * Permanently delete Departamento from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('departamento_delete')) {
            return abort(401);
        }
        $departamento = Departamento::onlyTrashed()->findOrFail($id);
        $departamento->forceDelete();

        return redirect()->route('admin.departamentos.index');
    }
}

                