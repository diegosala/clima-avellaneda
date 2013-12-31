<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="content-type" content="text/html; charset=UTF8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<title>Clima Avellaneda</title>
	<link rel="stylesheet" type="text/css" href="/min/g=css">    
    </head>
    <style type="text/css">
	@yield('content-css')
    </style>
    <body>
    <div id="wrap">
        @section('navbar')
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ClimaSurGBA ~ Avellaneda</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
                <ul class="nav navbar-nav">
                    <li <?php if (Request::is('/')) { ?>class="active"<?php } ?>><a href="/">Actuales</a></li>
		    <li class="dropdown<?php if (Request::is('archivo/*')) { ?> active<?php } ?>">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Archivo<b class="caret"></b></a>
			    <ul class="dropdown-menu">
				    <li @if (isset($daily_section)) class="active" @endif ><a href="<?php echo action("DailyController@Main") ?>">Diario</a></li>
				    <li @if (isset($monthly_section)) class="active" @endif ><a href="<?php echo action("MonthlyController@Main") ?>">Mensual</a></li>
				    <li @if (isset($yearly_section)) class="active" @endif ><a href="<?php echo action("YearlyController@Main") ?>">Anual</a></li>
			    </ul>
		    </li>
                    <li <?php if (Request::is('graficos')) { ?>class="active"<?php } ?>><a href="/graficos">Gr&aacute;ficos</a></li>
                    <li <?php if (Request::is('contacto')) { ?>class="active"<?php } ?>><a href="<?php echo action("ContactController@Main") ?>">Contacto</a></li>
                </ul>
            </div>
        </div>
        </nav>            
        @show
        <div class="container">
                @yield('content')
        </div>
    </div>
    <div id="footer">
    <div class="container">
        <p>&copy; <?php echo date("Y") ?> - Clima Avellaneda <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" /></a> Ubicación: <a id="mapaUbicacion" href="https://maps.google.com/?ll=-34.66571,-58.364726&spn=0.03015,0.066047&t=h&z=19&output=embed">34º39'57" S - 58º21'53" W</a></p>
        @yield('content-footer')
    </div>
</div>            
    <script src="/min/?g=js"></script>    
    <script type="text/javascript">
    $(document).ready(function() {
        $("#mapaUbicacion").fancybox({'type': 'iframe'});
    });
    </script>
    @yield('content-js')	
    </body>
</html>
