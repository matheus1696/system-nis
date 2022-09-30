@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-create>
        @slot('title'){{$title}}@endslot
        @slot('route'){{route('qualifications.create')}}@endslot
    </x-titles.title-create>

@endsection

@section('content')
    <section class="mx-md-5">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-valign-middle">

                    <thead class="text-center">
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
                                                                                
                                            <x-buttons.button-icon-show>
                                                @slot('route')
                                                    {{route('qualifications.show',['qualification' => $capacitacao->id])}}
                                                @endslot
                                            </x-buttons.button-icon-show>

                                            @can('admin_capacitacao')
                                                <x-buttons.button-icon-delete>
                                                    @slot('route')
                                                        {{route('qualifications.destroy',['qualification' => $capacitacao->id])}}
                                                    @endslot
                                                </x-buttons.button-icon-delete>
                                            @endcan

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
