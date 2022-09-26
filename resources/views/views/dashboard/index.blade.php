@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="row justify-content-center my-3">
        <div>{{$title}}</div>
    </h1>
@endsection

@section('content')
    <section class="mx-5">
        <div class="m-auto px-3 py-3">

            <div class="row">
                @foreach ($dashboards as $dashboard)
                    <div>
                        <a href="{{route('painel.show',['painel'=>$dashboard->id])}}" class="btn btn-app bg-success p-2">
                            <i class="fas fa-file-medical pb-2"></i> {{$dashboard->titulo}}
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection