<div class="row">
	<div class="col-xs-6 noPadding">
	<!-- main content -->
		<div class="page-header">
			<h2 style="margin: 0px 0px 10px 0px;">{{ $big }} <small>{{ $small }}</small></h2>
		</div>
	</div>
	@if ($calendar)
	@include('layouts.partials.calendar')
	@endif
</div>