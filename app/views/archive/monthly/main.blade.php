@section('archive')
<h1>Archivo mensual</h1>
@if ((isset($month)) && (@$month->id > 0))
@include('archive.monthly.detail')
@endif
@stop

