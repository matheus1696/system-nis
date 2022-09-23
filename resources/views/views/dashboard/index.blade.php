@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="row justify-content-center my-3">
        <div>{{$title}}</div>
    </h1>
@endsection

@section('content')
    <section class="mx-5">
        <div class="card m-auto px-3 py-2">

            <div class="row">
                @foreach ($dashboards as $dashboard)
                    <div class="col-2">
                        <a href="{{route('painel.show',['painel'=>$dashboard->id])}}" class="row justify-content-center align-items-center bg-success" style="height: 150px; border: 5px solid white">
                            <p>{{$dashboard->titulo}}</p>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection