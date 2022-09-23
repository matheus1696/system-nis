@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <div class="row justify-content-center align-items-center text-center m-4">
        <h1 class="col-md-10">{{$title}}</h1>
        <div class="col-md-1"><h1><a href="{{route('qualifications.create')}}" class="text-success"><i class="fas fa-plus-circle"></i></a></h1></div>
    </div>

@endsection

@section('content')
    <section class="mx-md-5">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-valign-middle">

                    <thead class="text-center bg-success">
                        <tr>
                            <th>Título</th>
                            <th>Local</th>
                            <th>Data de Realização</th>
                            <th>Carga Horária</th>
                            <th>Servidores</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                            @foreach ($capacitacoes as $capacitacao)
                                <tr>
                                    <td>{{$capacitacao->titulo}}</td>
                                    <td>{{$capacitacao->tb_locais_auditorios->name}}</td>
                                    <td>{{date('d/m/Y', strtotime($capacitacao->data_realizacao));}}</td>
                                    <td>{{$capacitacao->carga_horaria}} Horas</td>
                                    <td>{{$capacitacao->quant_capacitado}}</td>
                                    <td>
                                        <div class="row justify-content-center">

                                            <a href="{{route('qualifications.show',['qualification' => $capacitacao->id])}}" class="text-success btn btn-sm"><i class="fas fa-eye"></i></a>

                                            <form action="{{route('qualifications.destroy',['qualification' => $capacitacao->id])}}" method="post">
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
        </div>

        <div>
            {{$capacitacoes->links('pagination::bootstrap-5')}}
        </div>

        @if (Session::has('error'))
            <script>alert('{{session('error')}}')</script>
        @endif

    </section>

@endsection
