@section('archive')
<h1>Archivo anual</h1>
@if ((isset($year)) && (@$year->id > 0))
@include('archive.yearly.detail')
@endif
@stop
