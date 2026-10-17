<x-layouts::app>

		<flux:breadcrumbs class="mb-4">
			<flux:breadcrumbs.item :href="route('permissions.index')">
				Index Permissions
			</flux:breadcrumbs.item>
			<flux:breadcrumbs.item>
				Mis à jour
			</flux:breadcrumbs.item>
		</flux:breadcrumbs>

	
	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Mettre à jour une permission')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('permissions.update', $permission) }}" method="POST" class="flex flex-col gap-6 w-96">
				@csrf 
				@method('PUT')
				<flux:input class="max-w-xs" label="Nom" name="name" value="{{ old('name', $permission->name) }}" placeholder="le nom de la permission" />
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Modifier
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>