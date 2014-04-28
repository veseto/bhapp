@extends('layout')

@section('content')
    @foreach($countries as $country)
        <p><a href="{{$country->country}}">{{$country->country}}</a></p>
    @endforeach
@stop