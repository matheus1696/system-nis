@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>

@endsection

@section('content')
    <section class="w-75 m-auto">
        <div class="card m-auto">
            
            <div class="card-body px-5 py-3">
                <form action="{{route('dashboard.update',['dashboard'=>$dashboard->id])}}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group row">
                        <label for="tituloDashboard" class="col-sm-12 col-form-label">Título</label>
                        <div class="col-sm-12">
                        <input type="text" class="form-control" id="tituloDashboard" name="tituloDashboard" value="{{$dashboard->titulo}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="linkDashboard" class="col-sm-12 col-form-label">Link</label>
                        <div class="col-sm-12">
                        <input type="text" class="form-control" id="linkDashboard" name="linkDashboard" value="{{$dashboard->link}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricaoDashboard">Descrição do Dashboard</label>
                        <textarea class="form-control" id="descricaoDashboard" name="descricaoDashboard" rows="3">{{$dashboard->descricao}}
                        </textarea>
                    </div>
                    
                    <div class="form-group row">

                        <x-buttons.button-block-edit></x-buttons.button-block-edit>

                        <x-buttons.button-block-back>
                            @slot('route'){{route('dashboard.index')}}@endslot
                        </x-buttons.button-block-back>

                    </div>
                  </form>
            </div>

        </div>
    </section>
@endsection