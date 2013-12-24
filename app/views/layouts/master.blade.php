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
                <li <?php if (Request::is('/graficos/*')) { ?>class="active"<?php } ?>><a href="graficos/">Gr&aacute;ficos</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </div>
    </nav>            
    @show
    <div>
            @yield('content')
    </div>
    <script src="/min/?g=js"></script>
    @yield('content-js')	
    </body>
</html>
