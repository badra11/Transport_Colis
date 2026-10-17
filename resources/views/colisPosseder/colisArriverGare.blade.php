<x-layouts::app>

	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Acceuil
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Colis Arriver
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

	</div>

	<x-message></x-message>
    <x-page-header :title="__('Liste des Colis Arriver')" :description="__('')" />

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
					<th scope="col" class="px-3 py-3 font-medium">
                        Envois
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
                        <td class="px-3 py-3">
                            {{ $coli->gareEnvois->gare }}
                        </td> 
                    </tr>
                @endforeach    
            </tbody>
        </table>
    </div>

</x-layouts::app>