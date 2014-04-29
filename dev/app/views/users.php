@extends('layout')

@section('content')
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.dataTables.css">
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>

    {{ Datatable::table()
    ->addColumn('id','Name')       // these are the column headings to be shown
    ->setUrl(route('api.users'))   // this is the route where data will be retrieved
    ->render() }}
@stop