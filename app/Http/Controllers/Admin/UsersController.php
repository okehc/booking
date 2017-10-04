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

        return view('admin.users.create', compact('roles'))->with('departamentos', $departamentos)->with('ubicaciones', $ubicaciones);
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
        
        $pass = $request['password'];
        $email = $request['email'];
        $hash = DB::connection('odbc')->selectOne("select EncryptByPassPhrase('fabe', '".$pass."' ) as hash" );

        $user = User::create($request->all());

        $id= DB::connection('odbc')->selectOne("SELECT id from users where email = '".$email."'  ");

        DB::connection('odbc')->update('UPDATE users SET hash = '.$hash->hash.' WHERE id='.$id->id.' ');

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

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles'));
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
        $user->update($request->all());



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
