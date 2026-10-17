<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('colis.index')">
			Index Depot de Colis
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Mis à jours
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>

	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Enregistrer un Colis')" :description="__('')" />
		<div class="justify-items-center p-6">
			<form action="{{ route('colis.update',$colis->id) }}" method="POST" >
				@csrf 
				@method('PUT')
				<div class="border-b-2 border-gray-300 pb-4">
					<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ">
						INFO ENVOYEUR
					</span>
				</div>
				<div class="flex gap-4 my-4">
					<flux:input class="max-w-xs" type="text" name="nom_envoyeur" value="{{ old('nom_envoyeur', $colis->nom_envoyeur) }}" placeholder="NOM DE L'ENVOYEUR" />
					<flux:input class="max-w-xs" type="text" name="numero_envoyeur" value="{{ old('numero_envoyeur', $colis->numero_envoyeur) }}" placeholder="NUMERO DE L'ENVOYEUR" />
				</div>	
				
				<div class="border-b-2 border-gray-300 pb-4">
					<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ">
						INFO DESTINATAIRE
					</span>
				</div>
				<div class="flex gap-4 my-4">
					<flux:input class="max-w-xs" type="text" name="nom_destinataire" value="{{ old('nom_destinataire', $colis->nom_destinataire) }}" placeholder="NOM DE DESTINATAIRE" />
					<flux:input class="max-w-xs" type="text" name="numero_destinataire" value="{{ old('numero_destinataire', $colis->numero_destinataire) }}" placeholder="NUMERO DE DESTINATAIRE" />
				</div>


				<div class="border-b-2 border-gray-300 pb-4">
					<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ">
						INFO COLIS
					</span>
				</div>
				<div class="flex gap-4 my-4">
					<flux:select class="max-w-xs" name="type_colis_id" >
						<option value="">SELECTIONNER LE TYPE DE COLIS</option>
						@foreach ($type_colis as $type)
							<option value="{{ $type->id }}" {{ old('type_colis_id', $colis->type_colis_id) == $type->id ? 'selected' : '' }}>
								{{ $type->type }}
							</option>
						@endforeach
					</flux:select>

					<flux:select class="max-w-xs" name="unite" oninput="showValue()" id="unite">
						<option value="">SELECTIONNER UNITE</option>		
							<option value="poids" {{ old('unite', $colis->unite) == 'poids' ? 'selected' : '' }}>POIDS</option>
							<option value="valeur" {{ old('unite', $colis->unite) == 'valeur' ? 'selected' : '' }}>VALEUR</option>
							<option value="forfait" {{ old('unite', $colis->unite) == 'forfait' ? 'selected' : '' }}>FORFAIT</option>
					</flux:select>

					<flux:input class="max-w-xs" type="text" name="quantite" value="{{ old('quantite', $colis->quantite) }}" placeholder="QUANTITE" id="quantite" oninput="showValue()"/>
					<flux:input class="max-w-xs" type="number" name="montant" value="{{ old('montant', $colis->montant) }}" placeholder="MONTANT" id="montant" oninput="showValue()"/>

					<flux:select class="max-w-xs" name="gare_destination">
						<option value="">DESTINATION</option>
						@foreach ($gares as $gare)
							<option value="{{ $gare->id }}" {{ old('gare_destination', $colis->gare_destination) == $gare->id ? 'selected' : '' }}>
								{{ $gare->gare }}
							</option>
						@endforeach
					</flux:select>
				</div>
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Modifier
					</flux:button>
				</div>
			</form>
		</div>
	</div>


	@push('js')
		<script>
			function showValue() {
				let qte = document.getElementById('quantite');
				let unit = document.getElementById('unite');
				let prix = document.getElementById('montant');
				// Sécurité : conversion en nombre
				let quantite = parseFloat(qte.value) || 0;
				
				// Reset prix
				prix.value = '';
				
				switch(unit.value.toLowerCase()) {  // .toLowerCase() pour être sûr
					case 'poids':
						prix.value = quantite * 500;
						break;
					case 'valeur':
						prix.value = (quantite * 5) / 100;
						break;
					case 'forfait':
						qte.value = 1;
						prix.value = 1000;
						qte.readOnly = true; // Empêche la modification de la quantité pour le forfait
						prix.readOnly = true; // Empêche la modification du prix pour le forfait
						break;
				}
				if(unit.value.toLowerCase() !== 'forfait') {
					qte.readOnly = false; // Permet la modification de la quantité pour les autres
					prix.readOnly = false; // Permet la modification du prix pour les autres
				}
			}
		
		</script>
@endpush



</x-layouts::app>

