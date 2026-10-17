<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('type_colis.index')">
			Index Type
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Nouveau
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>

	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Creer un Type de Colis')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('type_colis.store') }}" method="POST" >
				@csrf 
				<flux:input class="max-w-xs" label='Type' name="type" value="{{ old('type') }}" placeholder="Type de Colis" />
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Enregistrer
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>	