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
                <form action="{{route('dashboard.store')}}" method="POST">
                    @csrf @method('POST')
                    <div class="form-group row">
                        <label for="tituloDashboard" class="col-sm-12 col-form-label">Título</label>
                        <div class="col-sm-12">
                        <input type="text" class="form-control" id="tituloDashboard" name="tituloDashboard">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="linkDashboard" class="col-sm-12 col-form-label">Link</label>
                        <div class="col-sm-12">
                        <input type="text" class="form-control" id="linkDashboard" name="linkDashboard">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricaoDashboard">Descrição do Dashboard</label>
                        <textarea class="form-control" id="descricaoDashboard" name="descricaoDashboard" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group row">
                      <div class="col-sm-6">
                        <button type="submit" class="btn btn-block btn-success">Cadastrar</button>
                      </div>
                      <div class="col-sm-6">
                        <a href="{{route('dashboard.index')}}" class="btn btn-block btn-info">Voltar</a>
                      </div>
                    </div>
                  </form>
            </div>

        </div>
    </section>
@endsection