<div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
    <div>
        <div class="mt-8">
            <h3 class="form-legend">
                <h3 class="form-legend">
                    Informations personnelles
                </h3>
            </h3>
        </div>
        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label class="form-label" for="name">Nom & Prénom</label>
                <input type="text" id="name" placeholder="Nom complet" name="name" value="{{ old('name', optional($user)->name) }}" class="form-control" required>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" placeholder="exemple@email.com" name="email" value="{{ old('email', optional($user)->email) }}" class="form-control" required>
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
                <label class="form-label" for="phone">Téléphone</label>
                <input type="tel" id="phone" placeholder="+212XXXXXXXXX" name="phone" value="{{ old('phone', optional($user)->phone) }}" class="form-control">
            </div>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
                <label class="form-label" for="company">Entreprise</label>
                <input type="text" id="company" placeholder="Nom de l'entreprise" name="company" value="{{ old('company', optional($user)->company) }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
        <div>
            <h3 class="form-legend">
                <h3 class="form-legend">
                    Coordonnées personnelles
                </h3>
            </h3>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="address">Adresse postale</label>
            <div class="flex flex-col">
                <textarea name="address" class="form-control" rows="3" id="address">{{ old('address', optional($user)->address) }}</textarea>
                <p class="mt-2 text-sm text-gray-500">Renseignez l'adresse sans la ville et le pays.</p>
            </div>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="country">Pays</label>
            <select id="country" name="country" autocomplete="country" class="form-control" required>
                <option value="">Choisir un pays</option>
                @foreach(\Combindma\Richcms\Enums\Country::getValues() as $country)
                    <option value="{{ $country }}" @if($country === old('country', optional($user)->country?->value)) selected @endif>{{ $country }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="state">Région</label>
            <input type="text" id="state" placeholder="Grand Casablanca" name="state" value="{{ old('state', optional($user)->state) }}" class="form-control">
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="city">Ville</label>
            <input type="text" id="city" placeholder="Casablanca" name="city" value="{{ old('city', optional($user)->city) }}" class="form-control">
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="postcode">Code Postal</label>
            <input type="number" id="postcode" placeholder="20300" name="postcode" value="{{ old('postcode', optional($user)->postcode) }}" class="form-control">
        </div>
    </div>
    <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
        <div>
            <h3 class="form-legend">
                <h3 class="form-legend">
                    Autorisations
                </h3>
            </h3>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="password">Mot de passe</label>
            @if ($createForm)
                <input type="text" id="password" name="password" value="{{ old('password', Str::random(8)) }}" class="form-control" required>
            @else
                <input type="text" id="password" placeholder="Renseignez un mot de passe si vous souhaitez le modifier" name="password" value="{{ old('password') }}" class="form-control">
            @endif
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <label class="form-label" for="role">Role</label>
            <select class="form-control" name="role" id="role" required>
                <option value="">Choisir un role</option>
                @foreach(\Combindma\Richcms\Enums\Roles::asArray() as $key => $role)
                    <option value="{{ $role }}" @if(optional($user)->hasRole($role)) selected="" @elseif (old('role') === $role) selected="" @endif>
                        {{ \Combindma\Richcms\Enums\Roles::getDescription($role) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
            <div>
                <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700" id="label-email">
                    Notification
                </div>
            </div>
            <div class="mt-4 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg space-y-4">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input name="send_email" value="1" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label aria-hidden="true" class="form-label" for="send_email">Par email</label>
                            <p class="text-gray-500">Envoyer un email avec le mot de passe.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5">
        <div class="flex justify-end">
            <a href="{{ route('richcms::users.index') }}" class="btn-subtle">Annuler</a>
            <button type="submit" class="btn ml-2">Enregistrer</button>
        </div>
    </div>
</div>

