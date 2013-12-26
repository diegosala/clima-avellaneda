@section('archive')
<h1>Archivo anual</h1>
@if ((isset($year)) && (@$year->id > 0))
@include('archive.yearly.detail')
@else
<div id="dp" class="col-xs-4 col-xs-offset-4"></div>
@endif
@stop
@section('content-js')
@if (isset($datepicker_format))
@parent
<script type="text/javascript">
$('#dp').datepicker({
    format: '{{ $datepicker_format }}',
    startDate: '{{ $min_date }}',
    endDate: '{{ $max_date }}',
    language: "es",
    todayHighlight: true,
    startView: 2,
    minViewMode: 2,
}).on('changeDate', function(e){
     location.href = e.format();
});
</script>
@endif
@stop

