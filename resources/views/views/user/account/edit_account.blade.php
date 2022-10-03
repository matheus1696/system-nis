@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    
    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>

@endsection

@section('content')

    <section class="mx-5 py-3">

        <div class="card p-3">
            <div class="row justify-content-center">

                <div class="w-100 px-5 text-center">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                </div>
    
                <div class="w-50 px-5" style="border-right: 1px solid rgba(128, 128, 128, 0.500)">
    
                    <form method="POST" action="{{ route('account.update',['account'=>$users->id]) }}">
                        @method('PUT') @csrf
    
                        <!-- Name -->
                            <div class="mt-4">
                                <x-label for="name" :value="__('Name')" />
                                <x-input id="name" class="mt-1 w-100" type="text" name="name" :value="$users->name" required autofocus />
                            </div>
    
                        <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$users->email" required disabled style="background: rgba(128, 128, 128, 0.3)"/>
                            </div>
    
                        <!-- Button Submit -->
                            <div class="row justify-content-center mt-4">
                                <x-button>
                                    {{ __('Alterar Dados') }}
                                </x-button>
                            </div>
                    </form>
    
                </div>
    
                <div class="w-50 px-5">
    
                    <form method="POST" action="{{ route('account.update',['account'=>$users->id]) }}">
                        @method('PUT') @csrf
    
                        <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Nova Senha')" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            </div>
    
                        <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
    
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>
    
                        <!-- Button Submit -->
                            <div class="row justify-content-center mt-4">
                                <x-button>
                                    {{ __('Alterar Senha') }}
                                </x-button>
                            </div>
                    </form>
    
                </div>
            </div>
        </div>
    
        <div class="card p-3">

            <div>
                <h3 class="text-center py-3">Permissões</h3>
            </div>

            <form method="post" action="{{ route('account.access',['account'=>$users->id]) }}">
                @csrf

                <table class="table table-striped text-center">
                    <tbody>
                        @foreach ($permissions as $permission)
                            @if ($permission->name != 'super_adm')
                                <tr>
                                    <td>{{$permission->name}}</td>
                                    <td style="width: 150px">
                                        <select class="form-control form-control-sm" name='{{$permission->name}}'>
                                            <option selected value="deny">Negar</option>                                            
                                            <option 
                                                @foreach ($hasPermissions as $hasPermission)
                                                    @if ($permission->id === $hasPermission->permission_id)
                                                        @if ($hasPermission->model_id === $users->id)
                                                                selected                                                   
                                                        @endif                                                
                                                    @endif
                                                @endforeach value="{{$permission->id}}">Permitir
                                            </option>
                                        </select>
                                    </td>
                                </tr>    
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Button Submit -->
                    <div class="row justify-content-center mt-4">
                        <x-button>
                            {{ __('Alterar Permissões') }}
                        </x-button>
                    </div>
            </form>

        </div>

    </section>

@endsection
