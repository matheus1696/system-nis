@extends('adminlte::page')

@section('title', $title)

@section('content_header')    
    <div class="row justify-content-center align-items-center text-center m-4">
        <h1 class="col-md-10">{{$title}}</h1>
        <div class="col-md-1"><h1><a href="{{route('register')}}" class="text-success"><i class="fas fa-plus-circle"></i></a></h1></div>
    </div>
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
                                            <a href="{{route('account.edit',['account'=>$user->id])}}" class="btn btn-sm bg-warning m-1"><i class="fas fa-pen"></i></a>
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
