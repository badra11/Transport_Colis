<x-layouts::app>

	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                {{ __('Acceuil') }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
	</div>

    <x-page-header :title="__('Colis Déposser vers')" :description="__('')" />

	<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl inline-flex">
		<div class="grid auto-rows-min gap-4 md:grid-cols-6">
			@foreach ($colis as $coli)
				<div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
					<a href="{{ route('colisPosseder.listeColisVersGare') }}?gare_destination={{ $coli->gare->id }}" class="block h-full w-full">
						<flux:card class="space-y-6">
							<div class="flex">
								<div class="flex-1">	
									<flux:badge color="danger" icon="map-pin" variant="solid" size="sm"></flux:badge>
										<flux:text class="mt-2 text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-teal-400">
											{{ $coli->gare->gare }} ({{ $coli->nbr }})
										</flux:text>	
								</div>						
							</div>
							<div class="flex gap-4">
								<flux:spacer />		
							</div>
						</flux:card>
					</a>
					{{-- <x-placeholder-pattern class="absolute inset-0 z-10 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/> --}}
				</div>
			@endforeach
		</div>
	</div>

</x-layouts::app>