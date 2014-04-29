@extends('layout')

@section('breadcrumbs')
    <!-- breadcrumbs -->
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}">Home</a></li>
        <li><a href="{{ URL::to('countries') }}">Countries</a></li>
        <li>{{ HTML::linkAction('LeagueDetailsController@getLeaguesForCountry', array_get($data, 'country'), array('country' => array_get($data, 'country'))) }}</li>
        <li>{{ HTML::linkAction('LeagueDetailsController@getImportedSeasons', array_get($data, 'league'), array('country' => array_get($data, 'country'), 'league' => array_get($data, 'league'))) }}</li>
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
            <h3 class="noMarginPadding">Stats for  {{ array_get($data, 'country') }} / {{ array_get($data, 'league') }} <small>{{ array_get($data, 'season') }}</small></h3>
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
    All matches {{ array_get($data, 'all') }}<br>
    Draw matches {{ array_get($data, 'draw') }}<br>
    Home wins {{ array_get($data, 'home') }}<br>
    Away wins {{ array_get($data, 'away') }}<br>
    </div>
    <div>
    @foreach(array_get($data, 'distResults') as $dist)
    	{{ $dist->homeGoals }} - {{ $dist->awayGoals }} : {{ $dist->total }} <br>
 	@endforeach
 	</div>
 	<table>
    @foreach(array_get($data, 'seq') as $team => $seq)
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
 	@foreach(array_get($data, 'sSeq') as $sSeq)
        @if($sSeq->resultShort == 'H' || $sSeq->resultShort == 'A')
            <button title="({{$sSeq->homeGoals}}:{{$sSeq->awayGoals}}){{$sSeq->home}}-{{$sSeq->away}}&#13;{{$sSeq->matchDate}} {{$sSeq->matchTime}}" type="button" class="btn btn-success btn-xs w25">{{$sSeq->resultShort}}</button>&nbsp;
        @else 
            <button title="({{$sSeq->homeGoals}}:{{$sSeq->awayGoals}}){{$sSeq->home}}-{{$sSeq->away}}&#13;{{$sSeq->matchDate}} {{$sSeq->matchTime}}" type="button" class="btn btn-warning btn-xs w25">{{$sSeq->resultShort}}</button>&nbsp;
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