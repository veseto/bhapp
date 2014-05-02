<div class="col-xs-3" style="padding-top:7px;text-align:right;">
	<span><a href="#" class="btn-sm btn-default"><</a></span>&nbsp;<span><a href="#" class="btn-sm btn-default">today</a>&nbsp;<a href="#" class="btn-sm btn-default">></a>
</div>
<div class="col-xs-3 noPadding">
  <!-- calendar -->
  <div class="form-group pull-right noMargin" id="datepickid">
    <div class="input-group date">
		<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    	<input type="text" class="form-control input-sm" style="height: 36px; font-size: 110%;" disabled="disabled">
		<span class="input-group-addon"><a href="#" class="btn btn-xs">GO</a></span>
    </div>
  </div>
</div>

<script>
$('#datepickid div').datepicker({
			format: "dd.mm.yy",
			weekStart: 1,
			orientation: "top left",
			// autoclose: false,
			todayHighlight: true,
			multidate: true,
			multidateSeparator: " to ",
			beforeShowDay: function (date) {
			  if (date.getMonth() == (new Date()).getMonth())
			    switch (date.getDate()){
			      case 4:
			        return {
			          tooltip: 'Example tooltip',
			          classes: 'text-danger'
			        };
			      case 8:
			        return false;
			      case 12:
			        return "green";
			    }
			}
		});
</script>