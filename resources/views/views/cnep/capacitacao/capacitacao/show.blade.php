@extends('adminlte::page')

@section('title', $title)

@section('content')

    <section class="p-5">
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
                    @can('admin_capacitacao')
                        <a href="{{route('certificates.index',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-success">
                            <i class="fas fa-award"></i> Certificados
                        </a>    
                    @endcan
                    <a href="{{route('qualifications.edit',['qualification'=>$capacitacoes->id])}}" class="btn btn-app bg-warning">
                        <i class="fas fa-pen"></i> Editar
                    </a>
                    <a href="{{route('qualifications.index')}}"  class="btn btn-app bg-secondary">
                        <i class="fas fa-angle-double-left"></i> Voltar
                    </a>
                    @can('admin_capacitacao')
                        <form action="{{route('qualifications.destroy',['qualification'=>$capacitacoes->id])}}" method="post">
                            @method('DELETE') @csrf
                            <button type="submit" class="btn btn-app bg-danger">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>    
                    @endcan
                </div>

                <hr class="m-auto">


                <div class="row">
                    <div class="col-md-6">
                        @if (count($servidores))

                            <h5 class="text-center text-primary pt-4">Servidores Capacitados</h5>

                            <div class="table-responsive p-md-4" style="height: 400px">

                                <table class="table table-head-fixed text-nowrap">
                                    <thead class="text-center text-primary">
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
                            </div>

                            <hr class="m-auto">
                        @endif
                    </div>

                    <div class="col-md-6">
                        @if (count($palestrantes))

                            <h5 class="text-center text-info pt-4">Palestrantes</h5>
                            
                            
                            <div class="table-responsive p-md-4" style="height: 400px">                                

                                <table class="table table-head-fixed table-hover">
                                    <thead class="text-center text-info">
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
            </div>
        </div>
    </section>
@endsection
