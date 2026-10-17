<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('gares.index')">
			Index Gare
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Nouveau
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>

	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Creer une Gare')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('gares.store') }}" method="POST" >
				@csrf 
				<flux:input class="max-w-xs" label='Gare' name="gare" value="{{ old('gare') }}" placeholder="Nom de la ville de la Gare" />
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Enregistrer
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>	