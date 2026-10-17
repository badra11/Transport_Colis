<x-layouts::app>
	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                {{ __('Acceuil') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('colisPosseder.colisArriverVersGare')">
                {{ __('Colis Arriver de') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
	</div>

	<x-page-header :description="__('')">
		<x-slot name="title">
			{{ __('Colis Arriver de') }}
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
                                <form action="{{ route('colisPosseder.receptionColis', $coli->id) }}" method="POST" class="inline ">
                                    @csrf
                                    <flux:button icon="check" type="submit" color="green" variant="primary">
                                        Receptionner
                                    </flux:button>
                                </form>
                            </div>
                        </td> 
                    </tr>
                @endforeach    
            </tbody>
        </table>
    </div>

    <form action="{{ route('colisPosseder.receptionToutVersGare') }}" method="POST" class="inline receptionner_tout_form">
        @csrf
        <input type="hidden" name="receptionTout" value="{{ $gare->id }}">
        <flux:button icon="check" type="submit" color="green" variant="primary" class="mt-4 w-full">
            Tout Receptionner
        </flux:button>
    </form>

    @push('js')
        <script>
            document.querySelectorAll('.receptionner_tout_form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const gareNom = '{{ $gare->gare }}';
                    
                    Swal.fire({
                        title: 'Confirmation de réception',
                        text: `Réceptionner tous les colis de ${gareNom} ?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a', // green-600
                        cancelButtonColor: '#6b7280',  // gray-500
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