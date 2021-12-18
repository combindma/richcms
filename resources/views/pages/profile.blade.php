@extends('dashui::layouts.app')
@section('title', 'Profil')
@section('content')
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <form action="{{ route('richcms::profil.update') }}" method="POST">
                <div class="bg-white py-6 px-4 sm:p-6">
                    <div class="mb-4">
                        <h1 class="text-lg leading-6 font-medium text-gray-900">Modifier profil</h1>
                    </div>
                    @include('dashui::components.alert')
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label for="name" class="form-label">Nom & Prénom</label>
                        <input type="text" value="{{ old('name', auth()->user()->name) }}" name="name" id="name" autocomplete="name" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{ old('email', auth()->user()->email) }}" name="email" id="amail" autocomplete="email" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit" class="btn">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
