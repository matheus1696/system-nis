@extends('adminlte::page')

@section('title', $title)

@section('content')

    <section class="mx-md-5">
        <div class="pt-5">
            <div>
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
    
                <div class="card">
                    <div class="px-5 py-3">
                        <form action="{{route('licitacao.createItem',['licitacao'=>$DBlicitacoes->id])}}" method="POST" class="row">
                            @csrf @method('POST')
        
                            @foreach ($forms as $form)
        
                                @if ($form['tag'] === 'select')
                                    <div class="form-group {{$form['row']}}">
                                        <label>{{$form['title']}}</label>
                                        <select class="form-control" name="{{$form['id']}}" required>
                                            @foreach ($form['connection'] as $item)
                                                <option @if ($item->id == $form['value']) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
        
                                @if ($form['tag'] === 'textarea')
                                    <x-forms.form-textarea>
                                        @slot('row'){{$form['row']}}@endslot
                                        @slot('title'){{$form['title']}}@endslot
                                        @slot('id'){{$form['id']}}@endslot
                                        @slot('value'){!!old($form['value'])!!}@endslot
                                    </x-forms.form-textarea>
                                @endif
        
                                @if ($form['tag'] === 'input')
                                    <x-forms.form-input>
                                        @slot('row'){{$form['row']}}@endslot
                                        @slot('tag'){{$form['tag']}}@endslot
                                        @slot('type'){{$form['type']}}@endslot
                                        @slot('title'){{$form['title']}}@endslot
                                        @slot('id'){{$form['id']}}@endslot
                                        @slot('connection'){{$form['connection']}}@endslot
                                        @slot('required'){{$form['required']}}@endslot
                                        @slot('min'){{$form['min']}}@endslot
                                        @slot('minlength'){{$form['minlength']}}@endslot
                                        @slot('max'){{$form['max']}}@endslot
                                        @slot('maxlength'){{$form['maxlength']}}@endslot
                                        @slot('value'){!!old($form['value'])!!}@endslot
                                    </x-forms.form-input>
                                @endif
                                
                            @endforeach                   
        
                            <x-buttons.button-block-create></x-buttons.button-block-create>
        
                            <x-buttons.button-block-back>
                                @slot('route'){{route('dashboard.index')}}@endslot
                            </x-buttons.button-block-back>
        
                        </form>
                    </div>
                </div>
    
                <div class="card mb-3">
                    <div class="px-5 py-3">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-valign-middle">
    
                                <thead class="text-center">
                                    <tr>
                                        <th class="col-1">Itens</th>
                                        <th class="">Produtos</th>
                                        <th class="col-1">Tipo</th>
                                        <th class="col-1">Quant.</th>
                                        <th class="col-1"></th>
                                    </tr>
                                </thead>
    
                                <tbody class="text-center">
                                        @foreach ($DBitensLicitacao as $DBitemLicitacao)
                                            <tr>
                                                <td>{{$DBitemLicitacao->n_item}}</td>
                                                <td>{{$DBitemLicitacao->produto}}</td>                                    
                                                <td>{{$DBitemLicitacao->tipos_und}}</td>                                 
                                                <td>{{$DBitemLicitacao->quant}}</td>
                                                <td>
                                                    <div class="row justify-content-center">
                                                                                            
                                                        <x-buttons.button-icon-edit>
                                                            @slot('route')
                                                                {{route('licitacao.index')}}
                                                            @endslot
                                                        </x-buttons.button-icon-edit>
    
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                </tbody>
    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
