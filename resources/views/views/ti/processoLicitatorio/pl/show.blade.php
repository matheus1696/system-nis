@extends('adminlte::page')

@section('title', $title)

@section('content')

    <section class="mx-md-5">
        <div class="pt-5">
            <div class="card px-md-5 pt-md-5">
                <div class="row">
                    @foreach ($sections as $section)
                        <div class="{{$section['row']}} py-2">
                            <p>
                                <strong>{{$section['title']}}:</strong>                                
                                {{$section['value']}}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="row justify-content-center p-md-4">
                    <a href="{{route('servers.create',['qualification'=>$DBlicitacoes->id])}}" class="btn btn-app bg-primary">
                        <i class="fas fa-user-graduate"></i></i> Solicitar Renovação
                    </a>
                    <a href="{{route('licitacao.edit',['licitacao'=>$DBlicitacoes->id])}}" class="btn btn-app bg-success">
                        <i class="fas fa-archive"></i> Impressão
                    </a>
                    <a href="{{route('licitacao.edit',['licitacao'=>$DBlicitacoes->id])}}" class="btn btn-app bg-warning">
                        <i class="fas fa-pen"></i> Editar
                    </a>
                    <a href="{{route('licitacao.index')}}"  class="btn btn-app bg-secondary">
                        <i class="fas fa-angle-double-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
