@section('archive')
<h1>Archivo mensual</h1>
@if ($month > 0)
@include('archive.monthly.detail')
@endif
@stop

