@extends('dashui::layouts.login')
@section('title', 'Connexion')
@section('content')
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto" src="{{ asset('assets/img/logos/symbol.png') }}" alt="{{ config('app.name') }}" width="110">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Connexion
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 max-w">
            Cette section est reservée uniquement aux administrateurs
        </p>
        @include('dashui::components.alert')
    </div>
    <div class="mt-8 sm:mx-auto px-4 sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="{{ route('admin::login') }}" method="POST">
                <div>
                    <label for="email" class="form-label">
                        Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="form-control">
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label">
                        Mot de passe
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="form-control">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Mémoriser ma session
                    </label>
                </div>

                <div>
                    @csrf
                    {!! recaptchaInput() !!}
                </div>

                <div>
                    <button type="submit" class="btn w-full">
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
