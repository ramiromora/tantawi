<!doctype html>
<html lang="es" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Sistema de Actas OFEP</title>
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="Sistema Evaluador de Resultados">
        <meta property="og:site_name" content="OFEP">
        <meta property="og:description" content="Sistema Evaluador de Resultados de la Oficina Técnica para el Fortalecimiento de las Empresas en Bolivia">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/media/favicons/favicon-192x192.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/media/favicons/apple-touch-icon-180x180.png')}}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">

        <link rel="stylesheet" id="css-main" href="{{asset('assets/css/codebase.css')}}">
        <link rel="stylesheet" id="css-theme" href="{{asset('assets/css/themes/rojo.css')}}">

    </head>
    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('assets/media/photos/photo34@2x.jpg');">
                    <div class="row mx-0 bg-black-op">
                        <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                            <div class="p-30 invisible" data-toggle="appear">
                                <p class="font-size-h1 font-w600 text-white">
                                    <strong>Sistema de Actas</strong>
                                </p>
                                <p class="font-italic text-white-op">
                                    OFEP BOLIVIA  &copy; <span class="js-year-copy">2019</span>
                                </p>
                            </div>
                        </div>
                        <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                            <div class="content content-full">
                                <div class="px-30 py-10">
                                    <img src="../assets/media/ofep/logoxl.png" width="282" height="161" alt=""/>
                                    <h1 class="h3 font-w700 mt-30 mb-10">TANTAWI</h1>
                                    <h2 class="h5 font-w400 text-muted mb-0">ingrese sus credenciales</h2>
                                </div>
                                <form class="js-validation-signin px-30" action="{{url('login')}}" method="post">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material floating">
                                                <input type="text" class="form-control" id="username" name="username">
                                                <label for="username">Usuario</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material floating">
                                                <input type="password" class="form-control" id="password" name="password">
                                                <label for="password">Contraseña</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-hero btn-alt-danger">
                                            <i class="si si-login mr-10"></i> Ingresar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="{{asset('assets/js/codebase.core.min.js')}}"></script>
        <script src="{{asset('assets/js/codebase.app.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

        <!-- Page JS Code -->
        <script src="{{asset('assets/js/pages/op_auth_signin.min.js')}}"></script>

    </body>
</html>