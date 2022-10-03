@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-create>
        @slot('title'){{$title}}@endslot
        @slot('route'){{route('dashboard.create')}}@endslot
    </x-titles.title-create>
    
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
                                                                                
                                        <x-buttons.button-icon-edit>
                                            @slot('route')
                                                {{route('dashboard.edit',['dashboard'=>$dashboard->id])}}
                                            @endslot
                                        </x-buttons.button-icon-edit>

                                        <x-buttons.button-icon-delete>
                                            @slot('route')
                                                {{route('dashboard.destroy',['dashboard'=>$dashboard->id])}}
                                            @endslot
                                        </x-buttons.button-icon-delete>
                                        
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