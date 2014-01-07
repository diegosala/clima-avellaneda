@extends('layouts.archive')
@section('archive')
<div class="row">
	<div class="col-xs-8"><h1>Archivo diario</h1></div>
	@if ((isset($day)) && (@$day->id > 0))
	<div class="col-xs-4">
		<div id="dp" class="input-group date" style="padding-top: 25px">
			<input type="text" class="form-control">
			<div class="input-group-btn">
				<button class="btn btn-default"><i class="glyphicon glyphicon-calendar"></i></button>
			</div>
		</div>
	</div>
	@endif
</div>
@if ((isset($day)) && (@$day->id > 0))
@include('archive.daily.detail')
@else
<div id="dp" class="col-xs-4 col-xs-offset-4"></div>
@endif
@stop
@section('content-js')
@if (isset($datepicker_format))
@parent
<script type="text/javascript">
$("#dp").datepicker({
    format: '{{ $datepicker_format }}',
    startDate: '{{ $min_date }}',
    endDate: '{{ $max_date }}',
    language: "es",
    todayHighlight: true,
    autoClose: true,
    beforeShowDay: function(d) {
	@if ((isset($day)) && (@$day->id > 0))
	return d.getFullYear() + "/" + (d.getMonth() + 1) + "/" + d.getDate() != '{{ $avoid_date }}';
	@else
	return true;
	@endif
    }
}).on('changeDate', function(e){
    location.href = '/archivo/' + e.format();
});
@if ((isset($day)) && (@$day->id > 0))
$("#dp").datepicker('update','{{ $current_date }}');
@endif
</script>
@endif
@stop
