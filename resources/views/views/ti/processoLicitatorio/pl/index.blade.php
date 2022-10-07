@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-create>
        @slot('title'){{$title}}@endslot
        @slot('route'){{route('licitacao.create')}}@endslot
    </x-titles.title-create>

@endsection

@section('content')

    <section class="mx-md-5">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-valign-middle">

                    <thead class="text-center">
                        <tr>
                            <th class="col-1">Processos Licitatórios</th>
                            <th class="col-1">Pregão Eletrônico</th>
                            <th class="col-1">Registro Preço</th>
                            <th>Objetivo</th>
                            <th class="col-1">Data Vencimento</th>
                            <th class="col-1">Status</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                            @foreach ($DBlicitacoes as $licitacao)
                                <tr 
                                @if (
                                    strtotime($licitacao->data_vencimento) < strtotime('+60 day') || 
                                    $licitacao->tb_ti_status_processos_lic->name === 'Saldo Zerado' ||
                                    $licitacao->tb_ti_status_processos_lic->name === 'Vencido' 
                                )
                                    class="table-danger"
                                @endif
                                >
                                    <td>{{$licitacao->p_licitatorio}}</td>
                                    <td>{{$licitacao->p_eletronico}}</td>                                    
                                    <td>{{$licitacao->r_preco}}</td>                                 
                                    <td>{{$licitacao->objetivo}}</td>      
                                    <td>{{date('d/m/Y',strtotime($licitacao->data_vencimento))}}</td>
                                    <td><span class="badge badge-{{$licitacao->tb_ti_status_processos_lic->cor}}">{{$licitacao->tb_ti_status_processos_lic->name}}</span></td>  
                                    <td>
                                        <div class="row justify-content-center">
                                                                                
                                            <x-buttons.button-icon-show>
                                                @slot('route')
                                                    {{route('licitacao.show',['licitacao' => $licitacao->id])}}
                                                @endslot
                                            </x-buttons.button-icon-show>

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