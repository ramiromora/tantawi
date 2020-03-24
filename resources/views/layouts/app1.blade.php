<!DOCTYPE html>
<html>
<head>
  <meta lang="es"> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inicio | Oficina Técnica para el Fortalecimiento de la Empresa Pública</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/vendor/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('/vendor/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ asset('/vendor/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/css/AdminLTE2.css')}}">
  <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/css/skins/skin-red.css')}}">
</head>
<body class="skin-red sidebar-mini" style="height: auto; min-height: 100%;">
    <!--table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="background-image: url({{ asset('img/rojo1.jpg') }})" align="center"><img class="imagen" src="{{ asset('img/header_logo.jpg') }}" /></td>
        </tr>
        espacio para un baner
      </table-->


    <div class="wrapper" style="height: auto; min-height: 100%;">
    
      <header class="main-header">
          <a href="/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Ofep</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Texto de Ejemplo</b></span>      
          </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>
          <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false" style="height: 1px;">
              <!-- no borrar esta etiqueta por que si no la varra de navegacion resposiva se desconfigura -->
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                  <!-- Menu Toggle Button -->
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="{{asset('/img/tare.png')}}" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                      <img src="{{asset('/img/tare.png')}}" class="img-circle" alt="User Image">
                      <p>
                          {{ Auth::user()->name }}
                        <small>{{ Auth::user()->description }}</small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-right">
                          <a href="{{ route('logout') }}" class="btn btn-default btn-flat"onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                        </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <!-- /.navbar-custom-menu -->
          </div>
          <!-- /.container-fluid -->
        </nav>
      </header>

      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <ul class="sidebar-menu" data-widget="tree">
            <?php
            /*  para el menu hasta 4 niveles
            * primer nivel .
            * segundo nivel :
            * tercer nivel |
            * ejemplo 4.3:5    1.2:3|4
            */
            if(!isset($item)) { $item="1."; }
            ?>
            <li class="header">MENU PRINCIPAL</li>
          <li ><a href="/home"><em class="fa fa-home">&nbsp;</em> <span>Inicio</span></a></li>

            <li class="treeview">
              <a href="#">
                  <i class="fa fa-bell-o"></i> <span>Modulo 1</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
              <ul class="treeview-menu">
                <li> 
                  <a href="/ruta1/6.1:">
                    <span class="fa fa-gears">&nbsp;</span> Funcion 1
                  </a>
                </li>
                <li> 
                  <a href="/ruta2/6.2:">
                    <span class="fa fa-gears">&nbsp;</span> Funcion 2
                  </a>
                </li>
                <li> 
                  <a href="/ruta3/6.3:">
                    <span class="fa fa-gears">&nbsp;</span> Funcion 3
                  </a>
                </li>
    
              </ul>
            </li>
            
          <!-- MENU PDES -->
    
        <!--fin menu pedes-->
          <li class="header">
            <div class="text-center">
              <div class="text-success">
                
                <br>
                <i class="fa fa-check-circle"></i> <small><i class="fa fa-lock"></i> Secure Web</small>
              </div>
              <div>
          </li>
        </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Full Width Column -->
      <div class="content-wrapper" style="min-height: 615px;">
        <section class="content">
          <!-- Content Header (Page header) -->
          <!-- Main content -->
          
            @yield('content')
          
          <!-- /.content -->
        </section>
        <!-- /.container -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
          <div class="container">
            <div class="pull-right hidden-xs">
              <b> <span class="sucess"></span></b>
            </div>
            <strong>UGI &copy; 2019 <a href="https://ofep.gob.bo">OFEP</a></strong>
          </div>
          <!-- /.container -->
        </footer>
    </div>
    <!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="{{ asset('vendor/adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('vendor/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('vendor/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('vendor/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('vendor/adminlte/dist/js/demo.js')}}"></script>
</body>
</html>
