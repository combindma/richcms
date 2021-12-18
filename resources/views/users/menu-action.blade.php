<div class="relative inline-block text-left" x-data="{ open: false }" @keydown.escape="open = false"
     @click.away="open = false">
    <div>
        <button @click="open = !open" x-bind:aria-expanded="open"
                class="flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary-500"
                id="options-menu" aria-haspopup="true">
            <span class="sr-only">Open options</span>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
            </svg>
        </button>
    </div>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-75"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="z-10 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            @if (!$user->deleted_at)
                <a href="{{ route('richcms::users.edit', $user) }}"
                   class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                   role="menuitem">
                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
                    </svg>
                    Modifier
                </a>
                @if ($user->active)
                    <a href="{{ route('richcms::users.desactiver', $user) }}"
                       class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Désactiver
                    </a>
                @else
                    <a href="{{ route('richcms::users.activer', $user) }}"
                       class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Activer
                    </a>
                @endif
            @endif
        </div>
        <div class="py-1">
            @if ($user->deleted_at)
                <form
                    action="{{ route('richcms::users.restore', $user->id) }}"
                    method="POST"
                    class="menu__content js-menu__content">
                    @csrf
                    <a href="javascript:"
                       onclick='confirm("Etes-vous sûr de vouloir restaurer cet utilisateur ?") && parentNode.submit();'
                       class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem">
                        <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"/>
                        </svg>
                        Restaurer
                    </a>
                </form>
            @else
                <form action="{{ route('richcms::users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="javascript:"
                       onclick='confirm("Etes-vous sûr de vouloir supprimer cet utilisateur ?") && parentNode.submit();'
                       class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       role="menuitem">
                        <svg
                            class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Supprimer
                    </a>
                </form>
            @endif
        </div>
    </div>
</div>
