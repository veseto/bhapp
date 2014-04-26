@extends('layout')

@section('content')
        @foreach($seasons as $season)
    	<a href="{{$season->season}}/stats"> {{ $season->season }} </a><br>
 	@endforeach
@stop