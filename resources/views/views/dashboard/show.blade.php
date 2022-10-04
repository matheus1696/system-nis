@extends('adminlte::page')

@section('title', $title)

@section('content')

    {!!$dashboard->link!!}

@endsection

@section('css')
    <style>
        iframe{
            width: 100%;
            height: 100%;
        }
    </style>   
@endsection