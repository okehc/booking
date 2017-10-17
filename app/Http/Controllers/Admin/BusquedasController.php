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


                $busquedas = Busqueda::all();

        return view('admin.busquedas.index', compact('busquedas'));
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
        $busqueda = Busqueda::create($request->all());



        return redirect()->route('admin.busquedas.index');
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

                