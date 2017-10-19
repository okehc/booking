<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_access')) {
            return abort(401);
        }

                $users= DB::connection('odbc')->select('SELECT a.id, a.name, a.email, a.password, a.remember_token, a.created_at,
                    a.updated_at, a.role_id, a.apellido_paterno, a.apellido_materno,
                    a.deleted_at, b.nombre as ubicacion, c.departamento as departamento,
                    a.extension FROM users a JOIN ubicaciones b ON a.ubicacion = b.id
                    JOIN departamentos c ON a.departamento = c.id') ; 

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        
        $departamentos = DB::connection('odbc')->select('SELECT id, departamento FROM departamentos') ;   

        $ubicaciones= DB::connection('odbc')->select('SELECT id, nombre, estado FROM ubicaciones') ;

        foreach ($ubicaciones as $ub ) {
            $accesos[$ub->id] = DB::connection('odbc')->select("SELECT a.id, a.nombre_acceso, a.id_ubicacion FROM accesos a WHERE a.id_ubicacion =".$ub->id." ") ;
        }


        return view('admin.users.create', compact('roles'))->with('departamentos', $departamentos)->with('ubicaciones', $ubicaciones)->with('accesos', $accesos);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        
        $pass = $request->password;
        $email = $request->email;
        $hash = DB::connection('odbc')->selectOne("select EncryptByPassPhrase('password', '".$pass."' ) as hash" );



        $insert = DB::connection('odbc')->insert("INSERT INTO users (
                 name
                , email
                , password
                , created_at
                , role_id
                , apellido_paterno
                , apellido_materno
                , ubicacion
                , departamento
                , extension
                , acceso
                , hash )
            VALUES (
             '".$request->name."'
            , '".$request->email."'
            , EncryptByPassPhrase('password', '".$pass."' )
            , getdate()
            , '".$request->role_id."'
            , '".$request->apellido_paterno."'
            , '".$request->apellido_materno."'
            , '".$request->ubicacion."'
            , '".$request->departamento."'
            , '".$request->extension."'
            , '".$request->acceso."'
            , '".$hash->hash."'
         )");

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        
        $roles = \App\Role::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $user = DB::connection('odbc')->selectOne("SELECT a.id, a.name, a.email, a.password, a.created_at, a.role_id, a.apellido_paterno, a.apellido_materno, a.ubicacion, a.departamento, a.extension, a.acceso from users a WHERE a.id=".$id." ");


        $dep_default = DB::connection('odbc')->selectOne("SELECT a.id, a.departamento FROM departamentos a JOIN users b ON a.id = b.departamento WHERE b.id=".$id."");

        $deps = DB::connection('odbc')->select("SELECT a.id, a.departamento FROM departamentos a");

        $ub_default  = DB::connection('odbc')->selectOne("SELECT a.id, a.nombre, a.ciudad, a.estado from ubicaciones a join users b on a.id = b.ubicacion where b.id = '".$id."'  ");

        $ubs = DB::connection('odbc')->select(" SELECT a.id, a.nombre, a.ciudad, a.estado FROM ubicaciones a");

        foreach ($ubs as $ub ) {
            $acs[$ub->id] = DB::connection('odbc')->select("SELECT a.id, a.nombre_acceso, a.id_ubicacion FROM accesos a WHERE a.id_ubicacion =".$ub->id." ") ;
        }
    
        
        if ($user->role_id == 3){

            $ac_default = DB::connection('odbc')->selectOne("SELECT a.id, a.nombre_acceso, a.id_ubicacion from accesos a join users b on a.id = b.acceso where b.id = '".$id."'  ");            

            return view('admin.users.edit')->with('user', $user)->with('roles', $roles)->with('ub_default', $ub_default)->with('ubs', $ubs)->with('ac_default', $ac_default)->with('acs', $acs);

        } else {

            return view('admin.users.edit')->with('user', $user)->with('roles', $roles)->with('ub_default', $ub_default)->with('ubs', $ubs)->with('acs', $acs)->with('dep_default', $dep_default)->with('deps', $deps);

        }

        
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }

        $user = User::findOrFail($id);
        if ($request->password != '') {

            $pass = $request->password;
            $hash = DB::connection('odbc')->selectOne("select EncryptByPassPhrase('password', '".$pass."' ) as hash" );

            $update = DB::connection('odbc')->insert("UPDATE users SET 
                 name = '".$request->name."'
                , email = '".$request->email."'
                , password = EncryptByPassPhrase('password', '".$pass."' )
                , updated_at = getdate()
                , role_id = '".$request->role_id."'
                , apellido_paterno = '".$request->apellido_paterno."'
                , apellido_materno = '".$request->apellido_materno."'
                , ubicacion = '".$request->ubicacion."'
                , departamento = '".$request->departamento."'
                , extension = '".$request->extension."'
                , acceso = '".$request->acceso."'
                , hash = '".$hash."'
                WHERE id = ".$id." ");
        } else {

            $update = DB::connection('odbc')->insert("UPDATE users SET 
                 name = '".$request->name."'
                , email = '".$request->email."'
                , updated_at = getdate()
                , role_id = '".$request->role_id."'
                , apellido_paterno = '".$request->apellido_paterno."'
                , apellido_materno = '".$request->apellido_materno."'
                , ubicacion = '".$request->ubicacion."'
                , departamento = '".$request->departamento."'
                , extension = '".$request->extension."'
                , acceso = '".$request->acceso."'
                WHERE id = ".$id." ");
        }

        return redirect()->route('admin.users.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $location= DB::connection('odbc')->selectOne('SELECT a.nombre, a.ciudad, a.estado FROM ubicaciones a JOIN users b ON a.id = b.ubicacion  WHERE b.id = '.$id.' ');
        $departamento= DB::connection('odbc')->selectOne('SELECT a.departamento FROM departamentos a JOIN users b ON a.id = b.departamento  WHERE b.id = '.$id.' ');

        return view('admin.users.show', compact('user'))->with('location', $location)->with('departamento', $departamento);
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
