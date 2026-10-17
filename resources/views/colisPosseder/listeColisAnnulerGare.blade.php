<x-layouts::app>

	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Acceuil
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Colis Annuler
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

	</div>

	<x-message></x-message>
    <x-page-header :description="__('')">
		<x-slot name="title">
			{{ __('Colis Annuler vers') }}
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
                        Recuperateur
                    </th>
					<th>
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
                            {{ $coli->nom_destinataire }}
                            {{ $coli->numero_destinataire }}
                        </td>
						<td class="px-6 py-4">
                            <div class="flex space-x-2">
                               {{-- Bouton Renvoyer --}}
                                <form action="{{ route('colisPosseder.renvoyerColis', $coli->id) }}" method="POST" class="renvoyer-form">
                                    @csrf
                                    <flux:button type="submit" color="blue" variant="primary" icon="arrow-path">
                                        Renvoyer
                                    </flux:button>
                                </form>

                                {{-- Bouton Annuler définitivement --}}
                                <form action="{{ route('colisPosseder.annulerDefinitivement', $coli->id) }}" method="POST" class="annuler-form">
                                    @csrf
                                    <flux:button type="submit" color="red" variant="primary" icon="x-circle">
                                        Annuler
                                    </flux:button>
                                </form>
                            </div>
                        </td> 
                    </tr>
                @endforeach    
            </tbody>
        </table>
    </div>

@push('js')
    <script>
         document.querySelectorAll('.annuler-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible ! Le colis sera définitivement annulé.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Oui, annuler définitivement !',
                    cancelButtonText: 'Non',
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