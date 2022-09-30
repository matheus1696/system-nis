@extends('adminlte::page')

@section('title', $title)

@section('content_header') 

    <x-titles.title-create>
        @slot('title'){{$title}}@endslot
        @slot('route'){{route('register')}}@endslot
    </x-titles.title-create>
    
@endsection

@section('content')

    <section class="mx-5">
        <div class="card m-auto">
            
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Login</th>
                            <th></th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($users as $user)
                            @if ($loggedId != $user->id  /* Ocutar o Usuário Logado */)
                                
                                @if ($user->id != '1' /* Ocutar o Administrador de Sistema */)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>

                                            <x-buttons.button-icon-edit>
                                                @slot('route')
                                                    {{route('account.edit',['account'=>$user->id])}}
                                                @endslot
                                            </x-buttons.button-icon-edit>
                                            
                                        </td>
                                    </tr>
                                @endif
                            @endif   
                        @endforeach
                    </tbody>
                </table>
            </div>
    
        </div>
    </section>

@endsection
