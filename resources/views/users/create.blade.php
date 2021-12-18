@extends('dashui::layouts.app')
@section('title', 'Ajouter un utilisateur')
@section('content')
    <div class="bg-white border-l border-gray-200">
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto space-y-8 divide-y divide-gray-200">
                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                                Ajouter un utilisateur
                            </h1>
                        </div>
                        <div class="mt-4 md:mt-0 ml-4">
                            <a href="{{ route('richcms::users.index') }}" class="btn-subtle">Annuler</a>
                            <button onclick="document.getElementById('form-action').submit();" type="button" class="btn ml-2">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>

                <form action="{{ route('richcms::users.store') }}" method="POST" id="form-action">
                    @include('dashui::components.alert')
                    @csrf
                    @include('richcms::users.form', ['createForm' => true])
                </form>
            </div>
        </div>
    </div>
@endsection
