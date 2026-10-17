<x-layouts::app>

	<flux:breadcrumbs class="mb-4">
		<flux:breadcrumbs.item :href="route('roles.index')">
			Index Roles
		</flux:breadcrumbs.item>
		<flux:breadcrumbs.item>
			Mis à Jour
		</flux:breadcrumbs.item>
	</flux:breadcrumbs>
	
	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default ">
        <x-page-header :title="__('Mettre à jour le Role')" :description="__('')" />
		<div class="justify-items-center">
			<form action="{{ route('roles.update', $role) }}" method="POST" class="space-y-4 ">
				@csrf
				@method('PUT')
				<flux:input class="max-w-xs" label="Nom" name="name" value="{{ old('name',$role->name) }}" placeholder="le nom du role" />
				<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
					@foreach ($permissions as $permission )
					<div class="flex gap-4 *:gap-x-2">
						<input type="checkbox" name="permission[]" id="permission-{{ $permission->id }}" value="{{ $permission->name }}" {{ in_array($permission->name, old('permission', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }} />
						<label for="permission-{{ $permission->id }}">{{ ($permission->name) }}</label>
					</div>
					@endforeach
				</div>
				<div class="flex items-center my-4">
					<flux:button type="submit" variant="primary" class="w-xs">
						Modifier
					</flux:button>
				</div>
			</form>
		</div>
	</div>

</x-layouts::app>