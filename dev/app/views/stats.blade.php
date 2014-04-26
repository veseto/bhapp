@extends('layout')

@section('content')
    <h2>Here some stats for {{ array_get($stats, 'country') }} / {{ array_get($stats, 'leagueName') }} / {{ array_get($stats, 'season') }}</h2>
    All matches {{ array_get($stats, 'all') }}<br>
    Draw matches {{ array_get($stats, 'draw') }}<br>
    Home wins {{ array_get($stats, 'home') }}<br>
    Away wins {{ array_get($stats, 'away') }}<br>
    @foreach(array_get($stats, 'distResults') as $dist)
    	{{ $dist->homeGoals }} - {{ $dist->awayGoals }} : {{ $dist->total }} <br>
 	@endforeach
@stop