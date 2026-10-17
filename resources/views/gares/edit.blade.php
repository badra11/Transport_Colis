<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('gares.index')">
			Type de Colis
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Mis à jour
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>

	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Mettre à jour une Gare')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('gares.update', $gare) }}" method="POST">
				@csrf 
				@method('PUT')
				<flux:input class="max-w-xs" label='Gare' name="gare" value="{{ old('gare', $gare->gare) }}" placeholder="Nom de la ville de la Gare" />
				<div class="flex my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Modifier
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>	