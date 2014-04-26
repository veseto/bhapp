@extends('layout')

@section('content')
    @foreach($leagues as $league)
    	<a href="{{ URL::route('archive', array('country' => $league->country, 'league' => $league->fullName)) }}"> {{ $league->fullName }} </a><br>
 	@endforeach
@stop