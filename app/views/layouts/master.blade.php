<!DOCTYPE html>
<html>
    <head>
	<title>Clima Avellaneda</title>
	<link rel="stylesheet" href="/min/g=css">
    </head>
    <style type="text/css">
	@yield('content-css')
    </style>
    <body style="padding-top: 70px;">
    @section('navbar')
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ClimaSurGBA ~ Avellaneda</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Actuales</a></li>
                <li><a href="#">Grácos</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>            
    @show
    <div>
            @yield('content')
    </div>
    <script src="/min/?g=js"></script>
    @yield('content-js')	
    </body>
</html>
