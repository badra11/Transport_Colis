<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('users.index')">
			Index Utilisateur
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Mis à jours
			
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>


	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Mis à jour du compte Utilisateur')" :description="__('')" />
        <div class="justify-items-center">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="border-b-2 border-gray-300 pb-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ">
                        INFO UTILISATEUR
                    </span>
                </div>

                <div class="flex gap-4 my-4">
                    <flux:input name="name" value="{{ old('name', $user->name) }}" placeholder="Nom complet" label="Nom et Prenom" required />
                    <flux:input name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="exemple@laravel.com" autocomplete="off" label="Email" required />
                    <flux:input name="password" type="password" placeholder="Mot de passe" autocomplete="new-password" label="Mot de passe" required viewable />
                    <flux:input
                        name="password_confirmation"
                        :label="__('Comfirmer mot de passe')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Confirmer mot de passe')"
                        viewable
                    />
                </div>
                

                <div class="border-b-2 border-gray-300 pb-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ">
                        AUTORISATION
                    </span>
                </div>
                <div class="flex gap-4 my-4">
                    <flux:select class="max-w-xs" name="gare_id" id="gare_id" label="Gare D'affectation" searchable required>
                        <option value="">Rechercher une gare...</option>
                        @foreach ($gares as $gare)
                            <option value="{{ $gare->id }}" {{ old('gare_id', $user->gare_id) == $gare->id ? 'selected' : '' }}>
                                {{ $gare->gare }}
                            </option>
                        @endforeach
                    </flux:select>

                    <div class="w-0.5 h-20 bg-gray-400"></div>

                    <div class="flex flex-col gap-2 ">
                        <span class="text-sm font-medium text-gray-700">ROLES</span>
					@foreach ($roles as $role )
                        <div class="flex gap-4 *:gap-x-2">
                            <input type="checkbox" name="role[]" id="role-{{ $role->id }}" value="{{ $role->name }}" {{ in_array($role->name, old('role', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }} />
                            <label class="uppercase" for="role-{{ $role->id }}"> {{ ($role->name) }}</label>
                        </div>
                    @endforeach
                    </div>

                </div>

                

                <div class="flex items-center justify-end my-2">
                    <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                        {{ __('Modifier Compte') }}
                    </flux:button>
                </div>
            </form>
        </div>

       
    </div>

</x-layouts::app>	