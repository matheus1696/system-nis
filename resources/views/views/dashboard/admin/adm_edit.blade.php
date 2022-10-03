@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>

@endsection

@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        <h5>Ocorreu um erro durante a ediçao:</h5>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <section class="w-75 m-auto">
        <div class="card m-auto">
            
            <div class="card-body px-5 py-3">
                <form action="{{route('dashboard.update',['dashboard'=>$dashboard->id])}}" method="POST" class="row">
                    @csrf @method('PUT')

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
                                @slot('value'){{($form['value'])}}@endslot
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
                                @slot('value'){{$form['value']}}@endslot
                            </x-forms.form-input>
                            
                        @endif
                        
                    @endforeach

                    <x-buttons.button-block-edit></x-buttons.button-block-edit>

                    <x-buttons.button-block-back>
                        @slot('route'){{route('dashboard.index')}}@endslot
                    </x-buttons.button-block-back>

                </form>
            </div>

        </div>
    </section>
@endsection