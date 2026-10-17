<x-layouts::app>

	<div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Acceuil
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Type Colis
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('type_colis.create') }}" > 
            <flux:badge icon="plus-circle" variant="solid" color="zinc">
                nouveau   
            </flux:badge> 
        </a>
	</div>

	<x-message></x-message>

    <x-page-header :title="__('Liste des Type de colis')" :description="__('')" />
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="bg-neutral-secondary-soft border-b border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                    ID
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium" width="10px">
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($typecolis as $colis)
                    <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                        <td scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $colis->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $colis->type }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('type_colis.edit', $colis) }}" class="bg-blue-700 text-sm rounded-md text-white px-3 py-3">
                                    Edit
                                </a>

                                <form class="delete-form" action="{{ route('type_colis.destroy', $colis) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 text-sm rounded-md text-white px-3 py-3">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach    
            </tbody>
        </table>
    </div>

@push('js')
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush


</x-layouts::app>