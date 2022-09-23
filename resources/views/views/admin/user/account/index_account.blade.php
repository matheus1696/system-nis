@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1 class="row justify-content-center my-3">
        <div>{{$title}}</div>
        <div><a href="{{route('register')}}" class="btn btn-sm bg-success px-3 mx-5"><strong>+</strong></a></div>
    </h1>
@endsection

@section('content')

    <section class="w-75 m-auto">
        <div class="card m-auto">
            
            <div class="card-body p-0">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
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
                                            <a href="{{route('account.edit',['account'=>$user->id])}}" class="badge bg-info m-1">Editar</a>
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
