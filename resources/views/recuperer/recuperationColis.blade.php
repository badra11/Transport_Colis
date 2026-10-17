<x-layouts::app>

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                {{ __('Accueil') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                {{ __('Récupération Colis') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-page-header :description="__('Scannez ou saisissez le code de récupération pour réceptionner un colis')">
        <x-slot name="title">
            {{ __('Récupération de colis') }}
        </x-slot>
    </x-page-header>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
            <flux:icon name="check-circle" class="inline w-5 h-5 mr-2"/>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
            <flux:icon name="x-circle" class="inline w-5 h-5 mr-2"/>
            {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="mb-4 p-4 rounded-lg bg-yellow-100 text-yellow-800 border border-yellow-200">
            <flux:icon name="exclamation-triangle" class="inline w-5 h-5 mr-2"/>
            {{ session('warning') }}
        </div>
    @endif

    {{-- Formulaire de recherche par code --}}
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default p-6 mb-6">
        <form action="{{ route('recupererColis.verifierCode') }}" method="POST" class="max-w-md mx-auto">
            @csrf
            <div class="mb-4">
                <flux:label for="code_recuperation" class="block mb-2 text-lg font-medium">
                    Code de récupération
                </flux:label>
                <flux:input 
                    type="text" 
                    name="code_recuperation" 
                    id="code_recuperation" 
                    placeholder="Entrez le code de récupération..."
                    class="w-full text-center text-2xl tracking-widest uppercase"
                    required
                    autofocus
                />
            </div>
            <flux:button type="submit" color="blue" variant="primary" class="w-full" icon="magnifying-glass">
                Vérifier le code
            </flux:button>
        </form>
    </div>

    {{-- Résultat : Colis trouvé et prêt à être réceptionné --}}
    @if(session('colisTrouve'))
        @php $coli = session('colisTrouve'); @endphp
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border-2 border-green-500 p-6 mb-6 animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-green-600">
                    <flux:icon name="check-circle" class="inline w-6 h-6 mr-2"/>
                    Colis réceptionné et prêt à être rendu
                </h3>
                <flux:badge class="text-lg font-bold uppercase" color="success">{{ $coli->status_envois }}</flux:badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Numéro de suivi</p>
                    <p class="text-lg font-bold">{{ $coli->numero_année }}</p>
					<p class="text-lg font-bold">{{ $coli->numero_journée }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Type de colis</p>
                    <p class="text-lg font-bold">{{ $coli->TypeColis->type ?? 'N/A' }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Unité / Quantité</p>
                    <p class="text-lg font-medium">
						{{ $coli->unite }} / 
						{{ $coli->quantite }}
						<?php
							// Affichage de l'unité au singulier ou au pluriel
							if ($coli->unite ==='poids') {
								echo 'kg';
							} 
							if ($coli->unite ==='valeur' || $coli->unite ==='forfait') {
								echo "FCFA";
							}
							
						?>
					</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Montant</p>
                    <p class="text-lg font-bold text-green-600">{{ number_format($coli->montant, 0, ',', ' ') }} FCFA</p>
                </div>
                {{-- <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Envoyeur</p>
                    <p class="text-lg font-medium">{{ $coli->nom_envoyeur }}</p>
                    <p class="text-sm text-neutral-400">{{ $coli->numero_envoyeur }}</p>
                </div> --}}
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Destinataire</p>
                    <p class="text-lg font-medium">{{ $coli->nom_destinataire }}</p>
                    <p class="text-sm text-neutral-400">{{ $coli->numero_destinataire }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Gare d'envoi</p>
                    <p class="text-lg font-medium">{{ $coli->gareEnvois->gare ?? 'N/A' }}</p>
                </div>
                {{-- <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Gare de destination</p>
                    <p class="text-lg font-medium">{{ $coli->gare->gare ?? 'N/A' }}</p>
                </div> --}}
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 text-center">
                <p class="text-sm text-neutral-500 mb-2">Code de récupération</p>
                <p class="text-2xl font-mono font-bold tracking-wider text-yellow-800 bg-yellow-100 inline-block px-4 py-2 rounded">
                    {{ $coli->code_recuperation }}
                </p>
            </div>

            <form action="{{ route('recupererColis.rendreColis', $coli->id) }}" method="POST" class="rendre_form">
                @csrf
                <flux:button type="submit" color="green" variant="primary" class="w-full py-3 text-lg" icon="check">
                    Rendre Colis
                </flux:button>
            </form>
        </div>
    @endif

    {{-- Résultat : Colis déjà rendu --}}
    @if(session('colisDejaRendu'))
        @php $coli = session('colisDejaRendu'); @endphp
        <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border-2 border-yellow-500 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-yellow-600">
                    <flux:icon name="exclamation-triangle" class="inline w-6 h-6 mr-2"/>
                    Colis déjà réceptionné
                </h3>
                <flux:badge color="warning" size="lg">DÉJÀ RENDU</flux:badge>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Numéro</p>
                    <p class="text-lg font-bold">{{ $coli->numero_année }}-{{ $coli->numero_journée }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Type de colis</p>
                    <p class="text-lg font-medium">{{ $coli->TypeColis->type ?? 'N/A' }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Destinataire</p>
                    <p class="text-lg font-medium">{{ $coli->nom_destinataire }}</p>
                    <p class="text-sm text-neutral-400">{{ $coli->numero_destinataire }}</p>
                </div>
                <div class="bg-neutral-secondary-soft rounded-lg p-4">
                    <p class="text-sm text-neutral-500 mb-1">Date de réception</p>
                    <p class="text-lg font-bold text-green-600">
                        {{ $coli->date_rendu?->format('d/m/Y à H:i') ?? $coli->updated_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>

            <div class="p-4 bg-yellow-50 rounded-lg text-yellow-800 text-center border border-yellow-200">
                <flux:icon name="information-circle" class="inline w-5 h-5 mr-2"/>
                Ce colis a déjà été réceptionné. Impossible de le réceptionner à nouveau.
            </div>
        </div>
    @endif

    @push('js')
        <script>
            document.querySelectorAll('.rendre_form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Confirmation de réception',
                        text: 'Confirmez-vous la réception de ce colis ?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, réceptionner !',
                        cancelButtonText: 'Annuler',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush

</x-layouts::app>