@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
       <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/uploads/avatars/default.jpg" class="img-circle"
                     alt="User Image"/>
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                    <p>{{ env('APP_NAME', 'FaBe Manager') }}</p>
                @else
                    <p>{{ Auth::user()->name }}</p>
                @endif
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu">

            <li> 
                <a href="{{url('admin/calendar')}}">
                  <i class="fa fa-calendar"></i>
                  <span class="title">
                    Calendario
                  </span>
                </a>
            </li>
        
            @can('reservacion_access')
            <li class="{{ $request->segment(2) == 'reservacions' ? 'active' : '' }}">
                <a href="{{ route('admin.reservacions.index') }}">
                    <i class="fa fa-calendar-check-o"></i>
                    <span class="title">@lang('quickadmin.reservacion.title')</span>
                </a>
            </li>
            @endcan
            
            @can('user_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('role_access')
                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('quickadmin.roles.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('quickadmin.users.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            @can('adminitracion_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-asterisk"></i>
                    <span class="title">@lang('quickadmin.adminitracion.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('ubicacione_access')
                <li class="{{ $request->segment(2) == 'ubicaciones' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.ubicaciones.index') }}">
                            <i class="fa fa-map-marker"></i>
                            <span class="title">
                                @lang('quickadmin.ubicaciones.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('acceso_access')
                <li class="{{ $request->segment(2) == 'accesos' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.accesos.index') }}">
                            <i class="fa fa-universal-access"></i>
                            <span class="title">
                                @lang('quickadmin.accesos.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('seccion_access')
                <li class="{{ $request->segment(2) == 'seccions' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.seccions.index') }}">
                            <i class="fa fa-square-o"></i>
                            <span class="title">
                                @lang('quickadmin.seccion.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('item_access')
                <li class="{{ $request->segment(2) == 'items' ? 'active' : '' }}">
                        <a href="{{ route('admin.items.index') }}">
                            <i class="fa fa-check"></i>
                            <span class="title">
                                @lang('quickadmin.items.title')</span>
                        </a>
                    </li>
                @endcan
                @can('departamento_access')
                <li class="{{ $request->segment(2) == 'departamentos' ? 'active' : '' }}">
                    <a href="{{ route('admin.departamentos.index') }}">
                        <i class="fa fa-gears"></i>
                        <span class="title">@lang('quickadmin.departamentos.title')</span>
                    </a>
                </li>
                @endcan                
                </ul>
            </li>
            @endcan

            @can('busqueda_access')
            <li class="{{ $request->segment(2) == 'busquedas' ? 'active' : '' }}">
                <a href="{{ route('admin.busquedas.index') }}">
                    <i class="fa fa-gears"></i>
                    <span class="title">@lang('quickadmin.busquedas.title')</span>
                </a>
            </li>
            @endcan

            

            

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('auth.change_password') }}">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}
