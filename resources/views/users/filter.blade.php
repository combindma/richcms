<div class="border-b border-gray-200">
    <div class="sm:flex sm:items-baseline">
        <h3 class="text-md leading-6 font-medium text-gray-900">
            Filtrer par statut
        </h3>
        <div class="mt-4 sm:mt-0 sm:ml-10">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                <a href="{{ route('richcms::users.index') }}" class="@if(request()->missing('status')) tab--selected @else tab @endif">
                    Tous
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="@if(request()->get('status') === 'active') tab--selected @else tab @endif">
                    Actives
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}" class="@if(request()->get('status') === 'inactive') tab--selected @else tab @endif">
                    Bloqués
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}" class="@if(request()->get('status') === 'deleted') tab--selected @else tab @endif">
                    Supprimés
                </a>
            </nav>
        </div>
    </div>
</div>
