<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreItemsRequest;
use App\Http\Requests\Admin\UpdateItemsRequest;

class ItemsController extends Controller
{
    /**
     * Display a listing of Item.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('item_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('item_delete')) {
                return abort(401);
            }
            $items = Item::onlyTrashed()->get();
        } else {
            $items = Item::all();
        }

        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating new Item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('item_create')) {
            return abort(401);
        }
        return view('admin.items.create');
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param  \App\Http\Requests\StoreItemsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemsRequest $request)
    {
        if (! Gate::allows('item_create')) {
            return abort(401);
        }

        $query = "INSERT INTO items ( 
            item_nombre
            , item_descripcion
            , created_at) 
            VALUES ( 
            ".$request->item_nombre."
            , ".$request->item_descripcion."
            , getdate() )";



        return redirect()->route('admin.items.index');
    }


    /**
     * Show the form for editing Item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('item_edit')) {
            return abort(401);
        }
        $item = Item::findOrFail($id);

        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update Item in storage.
     *
     * @param  \App\Http\Requests\UpdateItemsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemsRequest $request, $id)
    {
        if (! Gate::allows('item_edit')) {
            return abort(401);
        }
        $item = Item::findOrFail($id);
        $item->update($request->all());



        return redirect()->route('admin.items.index');
    }


    /**
     * Display Item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('item_view')) {
            return abort(401);
        }
        $item = Item::findOrFail($id);

        return view('admin.items.show', compact('item'));
    }

}

                