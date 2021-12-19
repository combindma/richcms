@extends('dashui::layouts.app')
@section('title', 'Utilisateurs')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <div class="pb-8 sm:flex sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Utilisateurs
                    </h1>
                </div>
                <div class="mt-4 flex sm:mt-0 sm:ml-4">
                    <a href="{{ route('richcms::users.create') }}" class="btn">
                        Ajouter un utlisateur
                    </a>
                </div>
            </div>
            @include('dashui::components.alert')
            @include('richcms::users.filter')
        </div>

        @if ($users->isEmpty())
            @component('dashui::components.blank-state')
                @slot('icon')
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                @endslot
                @slot('heading')
                    Liste vide
                @endslot
                Aucun utilisateur trouvé
            @endcomponent
        @else
            <div class="-mx-4 sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pays
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Téléphone
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date inscription
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-primary-600">
                                                <span class="text-sm font-bold leading-none text-white">{{ strtoupper(substr($user->email, 0,2)) }}</span>
                                            </span>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium">
                                                    @if($user->name)
                                                        <a href="{{ route('richcms::users.edit', $user) }}" class=" text-gray-900">{{ ucwords($user->name) }}</a>
                                                    @else
                                                        <span class="text-red-400">Non renseigné</span>
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500 underline">
                                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->country?->value }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->phone)
                                            <a class="text-gray-900 underline" href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
                                        @else
                                            <span class="text-red-400">Non renseigné</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->registered_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($user->active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Actif</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Bloqué</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach($user->getRoleNames() as $role)
                                            {{ ucfirst($role) }}
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('richcms::users.menu-action', ['user' => $user])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($users->hasPages())
                            <div class="bg-white border-t border-gray-200 px-4 py-4 sm:px-6">
                                {{ $users->appends(request()->except('page'))->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
