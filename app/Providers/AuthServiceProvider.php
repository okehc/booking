<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Reservacion
        Gate::define('reservacion_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('reservacion_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('reservacion_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('reservacion_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Ubicaciones
        Gate::define('ubicacione_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('ubicacione_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('ubicacione_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('ubicacione_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('ubicacione_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Accesos
        Gate::define('acceso_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('acceso_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('acceso_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('acceso_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('acceso_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Seccion
        Gate::define('seccion_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('seccion_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('seccion_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('seccion_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('seccion_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Adminitracion
        Gate::define('adminitracion_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Items
        Gate::define('item_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('item_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('item_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('item_view', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Departamentos
        Gate::define('departamento_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('departamento_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('departamento_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('departamento_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('departamento_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });


        // Auth gates for: Busquedas
        Gate::define('busqueda_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('busqueda_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('busqueda_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
    }
}
