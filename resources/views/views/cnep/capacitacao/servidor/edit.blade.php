@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <div class="row justify-content-center align-items-center text-center m-4">
        <h1 class="col-md-12">{{$title}}</h1>
    </div>
@endsection

@section('content')
    <section class="mx-5">
        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5>Ocorreu um erro durante a criação:</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{route('servers.update',['server' => $servidores->id])}}" method="post" class="row">
                    @method('PUT')
                    @csrf
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
                        @else
                            <x-forms>
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
                                @slot('value'){{$form['value']}}@endslot
                            </x-forms>
                        @endif
                    @endforeach

                    <x-buttons.button-block-edit></x-buttons.button-block-edit>

                    <x-buttons.button-block-back>
                        @slot('route'){{route('qualifications.show',['qualification'=>$servidores->capacitacao_id])}}@endslot
                    </x-buttons.button-block-back>
                    
                </form>
            </div>
        </div>
    </section>

@endsection

