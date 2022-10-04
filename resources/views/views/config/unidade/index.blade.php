@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-create>
        @slot('title'){{$title}}@endslot
        @slot('route'){{route('unidade.create')}}@endslot
    </x-titles.title-create>

@endsection

@section('content')

    <section class="mx-md-5">
        <div class="card px-3 py-3">
            <table class="table table-hover table-valign-middle">

                <thead class="text-center">
                    <tr>
                        <th class="col-1">CNES</th>
                        <th>Unidade</th>                        
                        <th class="col-2">Classificação</th>
                        <th class="col-1">Status</th>
                        <th class="col-1"></th>
                    </tr>
                </thead>

                <tbody class="text-center">
                        @foreach ($DBunidades as $unidades)
                            <tr>
                                <td>{{$unidades->cnes}}</td>
                                <td>{{$unidades->name}}</td>
                                <td>{{$unidades->tb_config_blocos->name}}</td>
                                <td>{{$unidades->tb_config_status_unidades->name}}</td>
                                <td>
                                    <div class="row justify-content-center">

                                        <x-buttons.button-icon-edit>
                                            @slot('route')
                                                {{route('unidade.edit',['unidade' => $unidades->id])}}
                                            @endslot
                                        </x-buttons.button-icon-edit>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </tbody>

            </table>
        </div>
    </section>
@endsection