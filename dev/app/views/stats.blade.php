@extends('layout')

@section('breadcrumbs')
    <!-- breadcrumbs -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}">Home</a></li>
        <li><a href="#">Germany</a></li>
        <li><a href="#">3.Liga</a></li>
        <li class="active">Fixtures</li>
      </ol>
      <div class="pull-right">
        <span>fefence | <a href="#">settings</a> | <a href="#">log out</a></span>
      </div>
    </div>
@stop

@section('pageHeader')
    <div class="container">
      <div class="row">
        <div class="col-xs-6 noMarginPadding">
          <!-- main content -->
          <div class="page-header">
            <h3 class="noMarginPadding">Stats for  {{ array_get($stats, 'country') }} / {{ array_get($stats, 'leagueName') }} <small>{{ array_get($stats, 'season') }}</small></h3>
          </div>
        </div>
        <!-- <div class="col-xs-3" style="padding-top:4px;text-align:right;">
            <span><a href="#" class="btn-sm btn-default"><<</a></span>&nbsp;<span><a href="#" class="btn-sm btn-default">today</a>&nbsp;<a href="#" class="btn-sm btn-default">>></a>
        </div>
        <div class="col-xs-3 noMarginPadding">
          <!-- calendar -->
          <!--<div class="form-group pull-right" id="datepickid">
            <div class="input-group date">
              <input type="text" class="form-control input-sm"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
            </div>
          </div>
        </div> -->
      </div>
      
      <hr/>
@stop


@section('content')
    <div>
    All matches {{ array_get($stats, 'all') }}<br>
    Draw matches {{ array_get($stats, 'draw') }}<br>
    Home wins {{ array_get($stats, 'home') }}<br>
    Away wins {{ array_get($stats, 'away') }}<br>
    </div>
    <div>
    @foreach(array_get($stats, 'distResults') as $dist)
    	{{ $dist->homeGoals }} - {{ $dist->awayGoals }} : {{ $dist->total }} <br>
 	@endforeach
 	</div>
 	<table>
    @foreach(array_get($stats, 'seq') as $team => $seq)
    	<tr>
            <td><strong>{{$team}}</strong></td>
            <td> 
        	@foreach($seq as $s)
    	    	@if($s == 'W')
                    <button type="button" class="btn btn-success btn-xs w25">{{$s}}</button>&nbsp;
                @elseif($s == 'L') 
                    <button type="button" class="btn btn-danger btn-xs w25">{{$s}}</button>&nbsp;
                @else
                    <button type="button" class="btn btn-warning btn-xs w25">{{$s}}</button>&nbsp;
                @endif  
    	 	@endforeach
            </td>
        </tr>
	@endforeach
    </table>
 	@foreach(array_get($stats, 'sSeq') as $sSeq)
        @if($sSeq->resultShort == 'H' || $sSeq->resultShort == 'A')
            <button type="button" class="btn btn-success btn-xs w25">{{$sSeq->resultShort}}</button>&nbsp;
        @else 
            <button type="button" class="btn btn-warning btn-xs w25">{{$sSeq->resultShort}}</button>&nbsp;
        @endif
 	@endforeach
 	
@stop

@section('footer')
        <div id="footer">
          <div class="container">
            <p class="text-muted"> today's matches: <strong><a href="#">43</a></strong><strong> | </strong>BSF for today's matches: <strong>2213€</strong><strong> | </strong>Total BSF: <strong>5346€</strong></p>
          </div>
        </div>
    <script type="text/javascript">
    //   $('#datepickid div').datepicker({
    //     format: "dd.mm.yy",
    //     weekStart: 1,
    //     orientation: "top auto",
    //     // autoclose: false,
    //     todayHighlight: true,
    //     multidate: true,
    //     multidateSeparator: " to ",
    //     beforeShowDay: function (date) {
    //       if (date.getMonth() == (new Date()).getMonth())
    //         switch (date.getDate()){
    //           case 4:
    //             return {
    //               tooltip: 'Example tooltip',
    //               classes: 'text-danger'
    //             };
    //           case 8:
    //             return false;
    //           case 12:
    //             return "green";
    //         }
    //     }
    // });
    </script>
@stop