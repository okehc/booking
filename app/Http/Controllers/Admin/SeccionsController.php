<?php

namespace App\Http\Controllers\Admin;

use App\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSeccionsRequest;
use App\Http\Requests\Admin\UpdateSeccionsRequest;
use DB;

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
            
            try {
                $seccions= DB::connection('odbc')->select('SELECT a.id, b.nombre as id_ubicacion, a.nombre_seccion, a.id_atributos, a.created_at, a.updated_at, a.deleted_at, a.c_personas FROM seccions a JOIN ubicaciones b on a.id_ubicacion = b.id  ') ;     

            } catch (\Exception $ubicaciones) {
                die("Could not connect to the database.  Please check your configuration.");
            }

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
        
        # get ubications
        try {
            $ubicaciones= DB::connection('odbc')->select('SELECT id, nombre, estado FROM ubicaciones') ;                
        } catch (\Exception $ubicaciones) {
            die("Could not connect to the database.  Please check your configuration.");
        }

        #get items
        try {
            $items= DB::connection('odbc')->select('SELECT id, item_nombre, item_descripcion FROM items') ;                
        } catch (\Exception $items) {
            die("Could not connect to the database.  Please check your configuration.");
        }

        return view('admin.seccions.create')->with('ubicaciones', $ubicaciones)->with('items', $items);
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
          #count the items in seccion
          $request['id_atributos'] = count($request['item']);          

          # insert and get last id 
          $query = "INSERT INTO seccions ( id_ubicacion, nombre_seccion, id_atributos, created_at, c_personas ) 
                    VALUES ( ".$request->id_ubicacion." '".$request->nombre_seccion."', ".$request['id_atributos'].", getdate(), '".$request->c_personas."' )";
          $insert_seccion= DB::connection('odbc')->insert($query);

          $select_seccion = DB::connection('odbc')->selectOne("SELECT id from seccions WHERE nombre_seccion = '".$request->nombre_seccion."' AND c_personas = ".$request->c_personas." AND id_ubicacion = ".$request->id_ubicacion." ");



          try {
            foreach ($request['item'] as $item) {
              
                $inserted_items= DB::connection('odbc')->insert(
                                  "INSERT INTO items_seccions ( id_seccions, id_item, created_at ) 
                                  VALUES ( '".$select_seccion->id."', '".$item."', getdate()  )");        
            }
               
          } catch (\Exception $inserted_items) {
                die($inserted_items->getMessage());
          }          

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
        $location= DB::connection('odbc')->selectOne('SELECT a.id, a.nombre, a.ciudad, a.estado b.c_personas FROM ubicaciones a JOIN seccions b ON a.id = b.id_ubicacion  WHERE b.id = '.$id.' ');
        $ubicaciones= DB::connection('odbc')->select('SELECT id, nombre, ciudad, estado FROM ubicaciones') ;                
        $selected_items= DB::connection('odbc')->select('SELECT a.id_item, b.item_nombre, b.item_descripcion FROM items_seccions a 
                                                            JOIN items b ON a.id_item = b.id WHERE a.id_seccions =  '.$id.' ');
        $left_items = DB::connection('odbc')->select('SELECT a.id, a.item_nombre, a.item_descripcion FROM items a WHERE a.id NOT IN (SELECT b.id_item FROM items_seccions b WHERE b.id_seccions  = '.$id.')  ');


        return view('admin.seccions.edit', compact('seccion'))->with('location', $location )->with('ubicaciones', $ubicaciones)->with('selected_items', $selected_items)->with('left_items', $left_items);
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

        DB::connection('odbc')->delete('DELETE FROM items_seccions WHERE id_seccions = '.$id.' ');
          
          try {
            if(!empty($request['item'])) {
                foreach ($request['item'] as $item) {
                
                    $inserted_items= DB::connection('odbc')->insert(
                                      'INSERT INTO items_seccions ( id_seccions, id_item, created_at ) 
                                      VALUES ( '.$id.', '.$item.', getdate() )');        
                }
            }   
          } catch (\Exception $inserted_items) {
                die($inserted_items->getMessage());
          }  


        DB::connection('odbc')->update('UPDATE seccions SET id_ubicacion = '.$request['id_ubicacion'].' WHERE id='.$id.' ');
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

        # get items
        try {
            $find_items= DB::connection('odbc')->select('SELECT a.item_nombre, a.item_descripcion FROM items a JOIN items_seccions b ON a.id = b.id_item  WHERE b.id_seccions = '.$id.' ') ;
        } catch (\Exception $find_items) {
            die("Could not connect to the database.  Please check your configuration.");
        }

        $find_location= DB::connection('odbc')->selectOne('SELECT a.nombre, a.ciudad, a.estado FROM ubicaciones a JOIN seccions b ON a.id = b.id_ubicacion  WHERE b.id = '.$id.' ');
        return view('admin.seccions.show', compact('seccion'))->with('find_items', $find_items)->with('find_location', $find_location );
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
