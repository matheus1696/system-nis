@extends('adminlte::page')

@section('title', 'Painel')

@section('content_header')
    <h1>Painel de Controle</h1>
@endsection

@section('content')
    @can('user')
        <p>Usuário Comum</p>
    @endcan

    @can('admin')
        <p>Usuário de Administrador</p>
    @endcan

    @can('super_adm')
        <p>Administrador de Sistema</p>
    @endcan

@endsection

