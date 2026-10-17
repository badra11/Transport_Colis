<x-layouts::app>

    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                {{ __('Accueil') }}
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                {{ __('Colis Annuler') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <x-page-header :description="__('Colis definitivement annuler dans votre gare et les montants doivent être restituer à l\'envoyer de colis')">
        <x-slot name="title">
            {{ __('Colis Annuler') }}
        </x-slot>
    </x-page-header>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tableau des colis annuler --}}
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left text-body">
            <thead class="text-xs text-neutral-500 uppercase bg-neutral-secondary-soft border-b border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">ID</th>
                    <th scope="col" class="px-6 py-3 font-medium">N° Suivi</th>
                    <th scope="col" class="px-6 py-3 font-medium">Type de colis</th>
                    <th scope="col" class="px-6 py-3 font-medium">Unité / Quantité</th>
                    <th scope="col" class="px-6 py-3 font-medium">Montant</th>
                    <th scope="col" class="px-6 py-3 font-medium">Envoyeur</th>
                    <th scope="col" class="px-6 py-3 font-medium">Gare destination</th>
                    <th scope="col" class="px-6 py-3 font-medium">Annuler le</th>
                    <th scope="col" class="px-6 py-3 font-medium">Par</th>
                    <th scope="col" class="px-6 py-3 font-medium text-center">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @forelse($colisAnnuler as $coliAnnuler)
                    @php $coli = $coliAnnuler->colis; @endphp
                    <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft hover:bg-neutral-100 transition-colors">
                         <td class="px-6 py-3 font-medium">
                            {{ $coliAnnuler->id }}
                        </td>
                        <td class="px-6 py-3 font-medium text-blue-600">
                            {{ $coli->numero_année }} <br>
                            {{ $coli->numero_journée }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $coli->TypeColis->type ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $coli->unite }} <br>
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
                        </td>
                        <td class="px-6 py-3 font-bold text-red-600">
                            {{ number_format($coli->montant, 0, ',', ' ') }} FCFA
                        </td>
                       
                        <td class="px-6 py-3">
                            {{ $coli->nom_envoyeur }}<br>
                            <span class="text-xs text-neutral-400">{{ $coli->numero_envoyeur }}</span>
                        </td>
                        <td class="px-6 py-3">
                            {{ $coliAnnuler->gareDestination->gare ?? 'N/A' }}
                        </td>     
                        <td class="px-6 py-3 text-red-600 font-medium">
                            {{ $coliAnnuler->created_at->format('d/m/Y à H:i') }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $coliAnnuler->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <flux:badge color="success" size="sm">
                                ANNULER
                            </flux:badge>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-6 py-12 text-center text-neutral-400">
                            <flux:icon name="inbox" class="w-12 h-12 mx-auto mb-3 text-neutral-300"/>
                            <p class="text-lg font-medium">Aucun colis annuler</p>
                            <p class="text-sm">Les colis Annuler apparaîtront ici.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($colisAnnuler->hasPages())
        <div class="mt-4">
            {{ $colisAnnuler->links() }}
        </div>
    @endif

</x-layouts::app>