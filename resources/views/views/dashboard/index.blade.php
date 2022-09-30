@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>

@endsection

@section('content')
    <section class="mx-5">
        <div class="m-auto px-3 py-3">

            <div class="row">
                @foreach ($dashboards as $dashboard)
                    <div>
                        <a href="{{route('painel.show',['painel'=>$dashboard->id])}}" class="btn btn-app bg-{{$dashboard->tb_config_blocos->cor}} m-1">
                            {!!$dashboard->tb_config_icons->icons!!} {{$dashboard->titulo}}
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection