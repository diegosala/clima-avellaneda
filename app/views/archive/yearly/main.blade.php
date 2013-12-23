@section('archive')
<h1>Archivo anual</h1>
@if ($year > 0)
@include('archive.yearly.detail')
@endif
@stop
