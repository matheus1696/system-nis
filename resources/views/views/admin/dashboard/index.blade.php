@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <div class="row justify-content-center align-items-center text-center m-4">
        <h1 class="col-md-10">{{$title}}</h1>
        <div class="col-md-1"><h1><a href="{{route('dashboard.create')}}" class="text-success"><i class="fas fa-plus-circle"></i></a></h1></div>
    </div>
@endsection

@section('content')
    <section class="mx-5">
        <div class="card m-auto">
            
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="col-3">Título</th>
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
                                    <div class="row justify-content-center">
                                        <a href="{{route('dashboard.edit',['dashboard'=>$dashboard->id])}}" class="btn btn-sm bg-warning mx-1"><i class="fas fa-pen"></i></a>
                                        <form action="{{route('dashboard.destroy',['dashboard'=>$dashboard->id])}}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger mx-1"><i class="fas fa-trash"></i></button>
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