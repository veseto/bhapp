@extends('layout')

@section('content')
    @foreach($countries as $country)
        <p><a href="/dev/public/{{ $country->country }}">{{ $country->country }}</a></p>
    @endforeach
@stop