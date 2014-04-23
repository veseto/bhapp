@extends('layout')

@section('content')
    @foreach($seasons as $season)
        <p>{{ $season->season }}</p>
    @endforeach
@stop