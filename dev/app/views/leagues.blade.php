@extends('layout')

@section('content')
    @foreach($leagues as $league)
        <p><a href="/dev/public/{{ $league->country }}/{{ $league->fullName }}">{{ $league->fullName }}</a></p>
    @endforeach
@stop