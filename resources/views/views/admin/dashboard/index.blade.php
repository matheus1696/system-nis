@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="row justify-content-center my-3">
        <div>{{$title}}</div>
        <div><a href="{{route('dashboard.create')}}" class="btn btn-sm bg-success px-3 mx-5"><strong>+</strong></a></div>
    </h1>
@endsection

@section('content')
    <section class="w-75 m-auto">
        <div class="card m-auto">
            
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="col-4">Título</th>
                            <th>Descrição</th>
                            <th class="col-2"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dashboards as $dashboard)
                            <tr>
                                <td>{{$dashboard->titulo}}</td>
                                <td>{{$dashboard->descricao}}</td>
                                <td>
                                    <div class="row">
                                        <a href="{{route('dashboard.edit',['dashboard'=>$dashboard->id])}}" class="btn btn-sm bg-info m-1">Editar</a>
                                        <form action="{{route('dashboard.destroy',['dashboard'=>$dashboard->id])}}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger m-1">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection