@php
    $item=\Session::get('item');
    /* para el menu hasta 4 niveles
    * primer nivel .
    * segundo nivel :
    * tercer nivel |
    * ejemplo 4.3:5    1.2:3|4
    */
    if(!isset($item)) { $item="1."; }
@endphp

<div class="content-side content-side-full">
    <ul class="nav-main">
        <li>
            <a class="{{($item=='1')? "active" : null}}" href="/home"><i class="fa fa-home"></i><span class="sidebar-mini-hide">Inicio</span></a>
        </li>
        <li class="{{strstr($item,'.',true)=='2'?'open':null}}">
            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-book"></i><span class="sidebar-mini-hide">Actas</span></a>
            <ul>
                <li>
                    <a href="/act/index" class="{{(strstr($item,':',true)=='2.1')? "active":null}}"><span>MIS ACTAS</span></a>
                </li>
                <li>
                    <a href="/acts" class="{{(strstr($item,':',true)=='2.2')? "active":null}}"><span>ACTAS REGISTRADAS</span></a>
                </li>
                <li>
                    <a href="/trash"  class="{{(strstr($item,':',true)=='2.3')? "active":null}}"><span>ACTAS BORRADAS</span></a>
                </li>
            </ul>
        </li>
        {{-- <li>
            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-user"></i><span class="sidebar-mini-hide">Perfil</span></a>
            <ul>
                <li>
                    <a href="#"><span>MI PERFIL</span></a>
                </li>
            </ul>
        </li> --}}
        <li  class="{{strstr($item,'.',true)=='4'?'open':null}}">
            <a class="nav-submenu" data-toggle="nav-submenu" href="/guests/index"><i class="fa fa-users"></i><span class="sidebar-mini-hide">Contactos</span></a>
            <ul>
                <li>
                    <a href="{{route('guest.index')}}" class="{{(strstr($item,':',true)=='4.1')? "active":null}}"><span>CONTACTOS EMP. PÚBLICAS</span></a>
                </li>
            </ul>
        </li>
        @can('read.role')
        <li class="{{strstr($item,'.',true)=='5'?'open':null}}">
            <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-gears"></i><span class="sidebar-mini-hide">Ajustes</span></a>
            <ul>
                <li>
                    <a href="{{ route('role.index') }}" class="{{(strstr($item,':',true)=='5.1')? "active":null}}"><span>Roles</span></a>
                </li>
                <li>
                    <a href="{{ route('permission.index') }}" class="{{(strstr($item,':',true)=='5.2')? "active":null}}"><span>Permisos</span></a>
                </li>
                <li>
                    <a href="#"><span>Usuarios</span></a>
                </li>
                <li>
                    <a href="#"><span>Comites</span></a>
                </li>
            </ul>
        </li>
        @endcan
    </ul>
</div>
</div>