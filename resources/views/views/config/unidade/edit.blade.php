@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>
    
@endsection

@section('content')
    <section class="mx-md-5">
        <div class="card">
            <div class="card-body">

                <form action="{{route('unidade.update',['unidade'=>$DBunidades->id])}}" method="post" class="row">
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
                        @slot('route'){{route('unidade.index')}}@endslot
                    </x-buttons.button-block-back>

                </form>
            </div>
        </div>
    </section>

@endsection

