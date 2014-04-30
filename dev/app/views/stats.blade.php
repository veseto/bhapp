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
            <h3 style="margin-top: 0px;">{{ array_get($data, 'country') }} - {{ array_get($data, 'league') }} <small>{{ array_get($data, 'season') }}</small></h3>
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
      
      <!-- <hr/> -->
@stop


@section('content')
<!-- tabbed nav -->
<ul class="nav nav-tabs" style="border: none">
  <!-- <li class="active"><a href="#">Summay</a></li> -->
  <li><a href="#">Profile</a></li>
  <li><a href="#">Messages</a></li>
  <li class="active"><a href="#">Summay</a></li>
  <li><a href="#">Profile</a></li>
  <li><a href="#">Messages</a></li>
</ul>

<!-- table 1x2 -->
    <table class="table table-bordered">
      <tr>
          <th>League progress</th>
          <th width="25%"># of matches</th>
          <th width="25%">%</th>
      </tr>
      <tr>
        <td>Matches total</td>
        <td>{{ array_get($data, 'all') }}</td>
        <td>100 %</td>
      </tr>
      <tr>
        <td>Home win</td>
        <td>{{ array_get($data, 'home') }}</td>
        <td>?? %</td>
      </tr>
      <tr>
        <td>Draw</td>
        <td>{{ array_get($data, 'draw') }}</td>
        <td>?? %</td>
      </tr>
      <tr>
        <td>Away win</td>
        <td>{{ array_get($data, 'away') }}</td>
        <td>?? %</td>
      </tr>
    </table>

<!-- table exact score -->
    <table class="table table-bordered">
      <tr>
          <th>Exact score</th>
          <th width="25%"># of occurences</th>
          <th width="25%">%</th>
      </tr>
        @foreach(array_get($data, 'distResults') as $dist)
        <tr>
            <td>{{ $dist->homeGoals }} - {{ $dist->awayGoals }}</td>
            <td>{{ $dist->total }}</td>
            <td>?? %</td>
        </tr>
        @endforeach
    </table>

<!-- table goals scored -->
    <table class="table table-bordered">
      <tr>
          <th>Goals</th>
          <th width="25%">Total</th>
          <th width="25%">Per Match</th>
      </tr>
      <tr>
        <td>Goals scored</td>
        <td>??</td>
        <td>?? %</td>
      </tr>
      <tr>
        <td>Home goals</td>
        <td>??</td>
        <td>?? %</td>
      </tr>
      <tr>
        <td>Away goals</td>
        <td>?? </td>
        <td>?? %</td>
      </tr>
    </table>

<!-- table goals scored -->
    <table class="table table-bordered">
      <tr>
          <th>Over/Under 2.5 stats</th>
          <th width="25%">Total</th>
          <th width="25%">%</th>
      </tr>
      <tr>
        <td>Over 2.5</td>
        <td>??</td>
        <td>?? %</td>
      </tr>
      <tr>
        <td>Under 2.5</td>
        <td>??</td>
        <td>?? %</td>
      </tr>
    </table>

<!-- table PPS sequences -->
    <table class="table">
    @foreach(array_get($data, 'seq') as $team => $seq)
        <tr>
            <td><strong>{{$team}}</strong></td>
            <td>
            @foreach($seq as $s)
                <a href="#" type="button" data-toggle="tooltip" data-placement="top" title="<strong>{{$s->homeGoals}}:{{$s->awayGoals}}</strong>&nbsp;({{$s->home}}&nbsp;-&nbsp;{{$s->away}})<br/>{{ date("d.m.Y",strtotime($s->matchDate)) }}"  
                @if($s->resultShort == 'D')
                    {{'class="btn btn-warning btn-xs w25 hasTooltip">D'}} 
                @elseif(($s->resultShort == 'H' && $s->home == $team) || ($s->resultShort == 'A' && $s->away == $team))
                    {{'class="btn btn-success btn-xs w25 hasTooltip">W'}}
                @else 
                    {{'class="btn btn-danger btn-xs w25 hasTooltip">L'}}
                @endif
                </a>
            @endforeach
            </td>
        </tr>
    @endforeach
    </table>

<!-- table PPM sequence -->
    <div class="container noMarginPadding">
    <span class="text-default">Starts here</span>&nbsp;<span class="text-danger">Top 5 longest series: 13, 12, 12, 9, 5 (<-- hardcoded data, must re-visit!)</span><br/>
     	@foreach(array_get($data, 'sSeq') as $sSeq)
        <a href="#" type="button" data-toggle="tooltip" data-placement="top" title="<strong>{{$sSeq->homeGoals}}:{{$sSeq->awayGoals}}</strong>&nbsp;({{$sSeq->home}}&nbsp;-&nbsp;{{$sSeq->away}})<br/>{{ date("d.m.Y",strtotime($sSeq->matchDate)) }}" class="btn hasTooltip 
            @if($sSeq->resultShort == 'H' || $sSeq->resultShort == 'A')
                {{"btn-success"}} 
            @else 
                {{"btn-warning"}}
            @endif
            btn-xs w25">{{$sSeq->resultShort}}</a>
     	@endforeach
 	</div>
@stop

@section('footer')
    <div id="footer">
      <div class="container">
        <p class="text-muted"> today's matches: <strong><a href="#" class="hasTooltip" title="43">43</a></strong><strong> | </strong>BSF for today's matches: <strong>2213€</strong><strong> | </strong>Total BSF: <strong>5346€</strong></p>
      </div>
    </div>
    <script type="text/javascript">
    // Grab all elements with the class "hasTooltip"
    $('.hasTooltip').each(function() { // Notice the .each() loop, discussed below
        $(this).qtip({
            content: {
                text: $(this).attr('title')
            },
        style: {
            classes: 'qtip-light qtip-shadow qtip-rounded'
        },
        position: {
            viewport: $(window)
        }
        });
    });
    </script>
@stop