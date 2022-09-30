@extends('adminlte::page')

@section('title', $title)

@section('content_header')

    <x-titles.title-all>
        @slot('title'){{$title}}@endslot
    </x-titles.title-all>

@endsection

@section('content')

    <section class="card w-75 m-auto py-3">
        <div class="row justify-content-center">

            <div class="w-100 px-5 text-center">
                <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
            </div>

            <div class="w-50 px-5" style="border-right: 1px solid rgba(128, 128, 128, 0.500)">

                <form method="POST" action="{{ route('profile.update',['profile'=>Auth::user()->id]) }}">
                    @method('PUT') @csrf

                    <!-- Name -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$users->name" required autofocus />
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

                <form method="POST" action="{{ route('profile.update',['profile'=>Auth::user()->id]) }}">
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
    </section>

@endsection
