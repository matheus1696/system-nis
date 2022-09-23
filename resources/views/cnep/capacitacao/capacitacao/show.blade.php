@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <div class="row justify-content-center align-items-center text-center m-4">
        <h1 class="col-md-12">{{$title}}</h1>
    </div>

@endsection

@section('content')
    <section class="mx-md-5">
        <div class="card">
            <div class="card-body">
                <div class="row p-md-4">
                    @foreach ($sections as $section)
                        <div class="{{$section['row']}}">
                            <p><strong>{{$section['title']}}:</strong> {{$section['value']}}</p>
                        </div>
                    @endforeach
                </div>

                <hr class="m-auto">

                <div class="row justify-content-center p-md-4">
                    <a href="{{route('servers.create',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-primary">
                        <i class="fas fa-user-graduate"></i></i> Servidores
                    </a>
                    <a href="{{route('speakers.create',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-info">
                        <i class="fas fa-chalkboard-teacher"></i> Palestrantes
                    </a>
                    <a href="{{route('certificates.index',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-success">
                        <i class="fas fa-award"></i> Certificados
                    </a>
                    <a href="{{route('qualifications.edit',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-warning">
                        <i class="fas fa-pen"></i> Editar
                    </a>
                    <a href="{{route('qualifications.index')}}"  class="btn btn-app bg-secondary">
                        <i class="fas fa-angle-double-left"></i> Voltar
                    </a>
                    <form action="{{route('qualifications.destroy',['qualification'=>$capacitacoes->id])}}" method="post">
                        @method('DELETE') @csrf
                        <button type="submit" class="btn btn-app bg-danger">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </form>
                </div>

                <hr class="m-auto">


                @if (count($servidores))
                    <div class="table-responsive p-md-4">

                        <h5 class="text-center pb-2">Servidores</h5>

                        <table class="table table-hover table-valign-middle p-md-4">
                            <thead class="text-center bg-primary">
                                <tr class="row">
                                    <th class="col-md-6">Nome dos Participantes</th>
                                    <th class="col-md-4">CPF</th>
                                    <th class="col-md-2" style="width: 200px"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                    @foreach ($servidores as $servidor)
                                        <tr class="row">
                                            <td class="col-md-6">{{$servidor->servidor}}</td>
                                            <td class="col-md-4">{{$servidor->cpf}}</td>
                                            <td class="col-md-2">
                                                <div class="row justify-content-center">
                                                    <a href="{{route('servers.edit',['server'=>$servidor->id])}}" class="text-success btn btn-sm"><i class="fas fa-pen"></i></a>
                                                    <form action="{{route('servers.destroy',['server'=>$servidor->id])}}" method="post">
                                                        @method('DELETE') @csrf
                                                        <button type="submit" class="text-danger btn btn-sm"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>

                        <div>

                            {{ $servidores->onEachSide(15)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <hr class="m-auto">
                @endif

                @if (count($palestrantes))
                    <div class="table-responsive p-md-4">

                        <h5 class="text-center pb-2">Palestrantes</h5>

                        <table class="table table-hover table-valign-middle p-md-4">
                            <thead class="text-center bg-info">
                                <tr class="row">
                                    <th class="col-md-6">Nome dos Palestrantes</th>
                                    <th class="col-md-4">CPF</th>
                                    <th class="col-md-2"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                    @foreach ($palestrantes as $palestrante)
                                        <tr class="row">
                                            <td class="col-md-6">{{$palestrante->palestrante}}</td>
                                            <td class="col-md-4">{{$palestrante->cpf}}</td>
                                            <td class="col-md-2">
                                                <div class="row justify-content-center">
                                                    <a href="{{route('speakers.edit',['speaker' => $palestrante->id])}}" class="text-success btn btn-sm"><i class="fas fa-pen"></i></a>
                                                    <form action="{{route('speakers.destroy',['speaker' => $palestrante->id])}}" method="post">
                                                        @method('DELETE') @csrf
                                                        <button type="submit" class="text-danger btn btn-sm"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
