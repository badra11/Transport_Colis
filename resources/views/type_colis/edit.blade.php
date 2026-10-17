<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('type_colis.index')">
			Type de Colis
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Mis à jour
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>

	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Mettre à jour un Type de Colis')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('type_colis.update', $colis) }}" method="POST">
				@csrf 
				@method('PUT')
				<flux:input class="max-w-xs" label='Type' name="type" value="{{ old('type', $colis->type) }}" placeholder="Type de Colis" />
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Modifier
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>	