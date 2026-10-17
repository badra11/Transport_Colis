<x-layouts::app>

	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                {{ __('Acceuil') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('colisPosseder.colisEnCoursVersGare')">
                {{ __('Colis En Cours Vers') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
	</div>

    {{-- <x-page-header :title="__('Colis Déposer vers ' . $gare->gare)" :description="__('')" /> --}}
	<x-page-header :description="__('')">
		<x-slot name="title">
			{{ __('Colis En Cours Vers') }}
			<span class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-teal-400">
				{{ $gare->gare }}
			</span>
		</x-slot>
	</x-page-header>
	  <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="bg-neutral-secondary-soft border-b border-default">
                <tr>
                    <th scope="col" class="px-2 py-3 font-medium">
                    	ID
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Nombre Année
                    </th>
					<th scope="col" class="px-6 py-3 font-medium">
                        Nombre Journée
                    </th>
					<th scope="col" class="px-6 py-3 font-medium">
                       Type Colis
                    </th>
					<th scope="col" class="px-4 py-3 font-medium">
                        Unite
                    </th>
					<th scope="col" class="px-3 py-3 font-medium">
                        Quantité
                    </th>
					<th scope="col" class="px-6 py-3 font-medium">
                        Montant
                    </th>
					<th scope="col" class="px-6 py-3 font-medium">
                        Envoyeur
                    </th>
					<th scope="col" class="px-6 py-3 font-medium">
                        Recuperateur
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium" width="10px">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($colis as $coli)
                    <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                        <td scope="row" class="px-2 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $coli->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->numero_année }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->numero_journée }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->TypeColis->type }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $coli->unite }}
                        </td>
                        <td class="px-3 py-4">
                            {{ $coli->quantite }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->montant }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->nom_envoyeur }}
                            {{ $coli->numero_envoyeur }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $coli->nom_destinataire }}
                            {{ $coli->numero_destinataire }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
								 <form action="{{ route('colisPosseder.annulerEncours', $coli->id) }}" method="POST" class="inline annuler_form">
									@csrf
									<flux:button icon="x-mark" type="submit" color="red" variant="primary">
										Annuler
									</flux:button>
								</form>
                            </div>
                        </td> 
                    </tr>
                @endforeach    
            </tbody>
        </table>
		{{-- <div class="p-4">
			{{ $colis->links() }}
		</div> --}}
    </div>
	<form action="{{ route('colisPosseder.annulerToutVersGare') }}" method="POST" class="inline annuler_form">
		@csrf
		<input type="hidden" name="annulerTout" value="{{ $gare->id }}">
		<flux:button icon="x-mark" type="submit" color="red" variant="primary" class="mt-4 w-full">
			Tout Annuler
		</flux:button>
	</form>
	@push('js')
    {{-- <script>
        document.querySelectorAll('.envoyer_tout_form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Récupérer le nom de la gare depuis l'input hidden ou data-attribute
				//onclick="return confirm('Envoyer tous les colis vers {{ $gare->gare }} ?')"
                const gareNom = form.querySelector('button').textContent.trim() || 'cette gare';
                
                Swal.fire({
                    title: 'Confirmation d\'envoi',
                    text: `Envoyer tous les colis  ?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1d4ed8', // blue-700
                    cancelButtonColor: '#6b7280',  // gray-500
                    confirmButtonText: 'Oui, envoyer !',
                    cancelButtonText: 'Annuler',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script> --}}
@endpush
</x-layouts::app>